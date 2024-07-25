<template>
    <div>
        <h2>Attendance List</h2>
        <div class="grid-container">
            <div
                class="grid-item"
                v-for="(contact, index) in contacts"
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
                    {{ attendance.name }} - {{ attendance.attendanceDate }}
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            contacts: [
                { name: "John Doe", id: 1 },
                { name: "Jane Smith", id: 2 },
                { name: "Alice Johnson", id: 3 },
                { name: "John Doe", id: 4 },
                { name: "Jane Smith", id: 5 },
                { name: "Alice Johnson", id: 6 },
                { name: "John Doe", id: 7 },
                { name: "Jane Smith", id: 8 },
                { name: "Alice Johnson", id: 9 },
                { name: "John Doe", id: 10 },
                { name: "Jane Smith", id: 11 },
                { name: "Alice Johnson", id: 12 },
                { name: "John Doe", id: 13 },
                { name: "Jane Smith", id: 14 },
                { name: "Alice Johnson", id: 15 },
                { name: "John Doe", id: 16 },
                { name: "Jane Smith", id: 17 },
                { name: "Alice Johnson", id: 18 },
                { name: "John Doe", id: 19 },
                { name: "Jane Smith", id: 20 },
                { name: "Alice Johnson", id: 21 },
                { name: "John Doe", id: 22 },
                { name: "Jane Smith", id: 23 },
                { name: "Alice Johnson", id: 24 },
                { name: "John Doe", id: 25 },
                { name: "Jane Smith", id: 26 },
                { name: "Alice Johnson", id: 27 },
                { name: "John Doe", id: 28 },
                { name: "Jane Smith", id: 29 },
                { name: "Alice Johnson", id: 30 },
                { name: "John Doe", id: 31 },
                { name: "Jane Smith", id: 32 },
                { name: "Alice Johnson", id: 33 },
            ],
            selectedContacts: [],
            submittedAttendances: [],
        };
    },
    computed: {
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
            // Create attendance records for selected contacts
            this.selectedContacts.forEach((contact) => {
                const attendanceRecord = {
                    name: contact.name,
                    attendanceDate: new Date().toLocaleDateString(),
                };
                this.submittedAttendances.push(attendanceRecord);
            });

            // Clear selected contacts after submission
            this.selectedContacts = [];
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
