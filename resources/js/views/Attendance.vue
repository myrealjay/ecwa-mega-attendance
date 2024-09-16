<template>
    <div>
        <h2>Attendance List</h2>
        <div class="grid-container">
            <div
                class="grid-item"
                v-for="(contact, index) in allUsers"
                :key="index"
            >
                <label>
                    <input
                        type="checkbox"
                        v-model="selectedContacts"
                        :value="contact"
                    />
                    <p>{{ contact.name }}</p>
                </label>
            </div>
        </div>
        <div class="mt-3">
            <button
                @click="submitAttendance"
                :disabled="selectedContacts.length === 0"
                class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn"
            >
                Submit Attendance
            </button>
        </div>

        <div v-if="submittedAttendances.length > 0">
            <h3>Submitted Attendances:</h3>
            <ul>
                <li
                    v-for="(attendance, index) in submittedAttendances"
                    :key="index"
                >
                    <!-- {{ attendance.name }} - {{ attendance.phoneNumber }} -
                    {{ attendance.email }} - {{ attendance.attendanceDate }} -->
                </li>
            </ul>
        </div>

        <div class="attendance">
            <Attendants />
        </div>
    </div>
</template>

<script setup>
    import Attendants from './Attendants.vue';
    import {ref, onMounted, onBeforeMount, computed} from 'vue';
    import { useStore } from 'vuex'
    import { sweetAlert } from "../helpers/alerts.js";
    import { makeRequest } from '../helpers/requester.js'
    import { endpoints } from "../helpers/endpoints.js";
    import { showLoader, hideLoader } from "../helpers/loaders";


    const selectedContacts = ref([]);
    const submittedAttendances = ref([])
    const store = useStore();

    onMounted(() => {
        store.dispatch("fetchContactData");
    })

    onBeforeMount(() => {
        makeRequest('GET', endpoints().fetchAttendance).then(response => {
            selectedContacts.value = response.data.data;
        })
    })

    const contactData = computed(() => {
        return store.state.contactData;
    })

    const allUsers = computed(() => {
        let users = [];
        contactData.value.forEach(contact => {
            users.push({id:contact.id, name:contact.name})
        })

        return users;
    });

    function submitAttendance() {
        let record = [];
        // Create attendance records for selected contacts
        selectedContacts.value.forEach((contact) => {
            record.push(contact.id);
        });

        showLoader();
        makeRequest(
            "POST",
            endpoints().takeAttendance,
            {},
            { users: record }
        )
            .then((response) => {
                hideLoader();
                sweetAlert().success('Attendance successfully submitted');
            })
            .catch((error) => {
                hideLoader();
                if (error.response) {
                    sweetAlert().error(
                        error.response.data.message
                    );
                } else {
                    sweetAlert().error(error);
                }
            });
    }

</script>

<style>
.attendance {
    padding-top:30px;
}
.grid-container {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 10px;
}

.grid-item {
    padding: 10px;
    border: 1px solid #ccc;
}

button {
    margin-top: 10px;
    cursor: pointer;
}
label {
    display: flex;
    align-items: center;
}
label > p {
    color: #fff;
    margin-left: 10px;
    align-self: center;
}
input {
    align-self: center;
}
</style>
