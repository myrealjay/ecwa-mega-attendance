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
                    {{ contact.name }}
                </label>
            </div>
        </div>
        <button
            @click="submitAttendance"
            :disabled="selectedContacts.length === 0"
        >
            Submit Attendance
        </button>

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
                { name: "John Doe", id: 1 },
                { name: "Jane Smith", id: 2 },
                { name: "Alice Johnson", id: 3 },
                { name: "John Doe", id: 1 },
                { name: "Jane Smith", id: 2 },
                { name: "Alice Johnson", id: 3 },
                { name: "John Doe", id: 1 },
                { name: "Jane Smith", id: 2 },
                { name: "Alice Johnson", id: 3 },
                { name: "John Doe", id: 1 },
                { name: "Jane Smith", id: 2 },
                { name: "Alice Johnson", id: 3 },
                { name: "John Doe", id: 1 },
                { name: "Jane Smith", id: 2 },
                { name: "Alice Johnson", id: 3 },
                { name: "John Doe", id: 1 },
                { name: "Jane Smith", id: 2 },
                { name: "Alice Johnson", id: 3 },
                { name: "John Doe", id: 1 },
                { name: "Jane Smith", id: 2 },
                { name: "Alice Johnson", id: 3 },
                { name: "John Doe", id: 1 },
                { name: "Jane Smith", id: 2 },
                { name: "Alice Johnson", id: 3 },
                { name: "John Doe", id: 1 },
                { name: "Jane Smith", id: 2 },
                { name: "Alice Johnson", id: 3 },
                { name: "John Doe", id: 1 },
                { name: "Jane Smith", id: 2 },
                { name: "Alice Johnson", id: 3 },
            ],
            selectedContacts: [],
            submittedAttendances: [],
        };
    },
    computed: {
        // Calculate number of grid columns dynamically
        gridColumns() {
            return Math.ceil(this.contacts.length / 20);
        },
        // Split contacts into grid rows based on gridColumns
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
/* Add styling as per your preference */
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
</style>
