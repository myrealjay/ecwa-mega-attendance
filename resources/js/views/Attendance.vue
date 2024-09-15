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

<script>
import { mapState } from "vuex";
import Attendants from './Attendants.vue';
export default {
    data() {
        return {
            selectedContacts: [],
            submittedAttendances: [],
        };
    },
    mounted()
    {
        this.$store.dispatch("fetchContactData");
    },
    created() {
        this.makeRequest('GET', this.endpoints.fetchAttendance).then(response => {
            this.selectedContacts = response.data.data;
        })
    },
    components:{
        Attendants
    },
    computed: {
        ...mapState(["contactData"]),
        gridColumns() {
            return Math.ceil(this.contacts.length / 20);
        },

        gridRows() {
            const rows = [];
            for (let i = 0; i < this.gridColumns; i++) {
                rows.push(this.contacts.slice(i * 20, (i + 1) * 20));
            }
            return rows;
        },

        allUsers() {
            this.users = [];
            this.contactData.forEach(contact => {
                this.users.push({id:contact.id, name:contact.name})
            })

            return this.users;
        }
    },
    methods: {
        submitAttendance() {
            let record = [];
            // Create attendance records for selected contacts
            this.selectedContacts.forEach((contact) => {
                record.push(contact.id);
            });

            this.errors = {};
            this.showLoader();
            this.makeRequest(
                "POST",
                this.endpoints.takeAttendance,
                {},
                { users: record }
            )
                .then((response) => {
                    this.hideLoader();
                    this.sweetAlert().success('Attendance successfully submitted');
                })
                .catch((error) => {
                    this.hideLoader();
                    if (error.response) {
                        if (!error.response.data.data) {
                            this.sweetAlert().error(
                                error.response.data.message
                            );
                        } else {
                            this.errors = error.response.data.data;
                        }
                    } else {
                        this.sweetAlert().error(error);
                    }
                });
        },
    },
};
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
