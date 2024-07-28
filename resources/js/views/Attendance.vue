<template>
    <div>
        <h2>Attendance List</h2>
        <div class="grid-container">
            <div
                class="grid-item"
                v-for="(contact, index) in contactData"
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
    </div>
</template>

<script>
import { mapState } from "vuex";
export default {
    data() {
        return {
            selectedContacts: [],
            submittedAttendances: [],
        };
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
                    this.$router.push({
                        name: "dashboard",
                        query: { action: "new" },
                    });
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
