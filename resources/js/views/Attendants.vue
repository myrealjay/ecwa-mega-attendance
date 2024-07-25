<template>
    <div>
        <h2>Attendance by Date</h2>
        <div>
            <label for="date-select">Select Date:</label>
            <select id="date-select" v-model="selectedDate" class="date-select">
                <option value="" disabled>Select a date</option>
                <option
                    v-for="(date, index) in availableDates"
                    :key="index"
                    :value="date"
                >
                    {{ date }}
                </option>
            </select>
        </div>
        <div v-if="filteredAttendances.length > 0" class="attendance-list">
            <h3>Attendances on {{ selectedDate }}:</h3>
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Phone Number</th>
                        <th>Email</th>
                        <th>Address</th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="(contact, index) in paginatedContacts"
                        :key="index"
                    >
                        <td>{{ contact.name }}</td>
                        <td>{{ contact.phone }}</td>
                        <td>{{ contact.email }}</td>
                        <td>{{ contact.address }}</td>
                    </tr>
                </tbody>
            </table>
            <div class="pagination">
                <button
                    @click="prevPage"
                    :disabled="currentPage === 1"
                    class="previous"
                >
                    Previous
                </button>
                <span class="pages"
                    >Page {{ currentPage }} of {{ totalPages }}</span
                >
                <button
                    @click="nextPage"
                    :disabled="currentPage === totalPages"
                    class="next"
                >
                    Next
                </button>
            </div>
        </div>
        <div v-else>
            <p>No attendances recorded for the selected date.</p>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            selectedDate: "",
            attendances: [
                {
                    name: "John Doe",
                    phone: "123-456-7890",
                    email: "john@example.com",
                    address: "123 Main St",
                    attendanceDate: "1990-01-01",
                },
                {
                    name: "Jane Smith",
                    phone: "234-567-8901",
                    email: "jane@example.com",
                    address: "456 Elm St",
                    attendanceDate: "1985-05-15",
                },
                {
                    name: "John Doe",
                    phone: "123-456-7890",
                    email: "john@example.com",
                    address: "123 Main St",
                    attendanceDate: "1990-01-01",
                },
                {
                    name: "Jane Smith",
                    phone: "234-567-8901",
                    email: "jane@example.com",
                    address: "456 Elm St",
                    attendanceDate: "1985-05-15",
                },
                {
                    name: "John Doe",
                    phone: "123-456-7890",
                    email: "john@example.com",
                    address: "123 Main St",
                    attendanceDate: "1990-01-01",
                },
                {
                    name: "Jane Smith",
                    phone: "234-567-8901",
                    email: "jane@example.com",
                    address: "456 Elm St",
                    attendanceDate: "1985-05-15",
                },
                {
                    name: "John Doe",
                    phone: "123-456-7890",
                    email: "john@example.com",
                    address: "123 Main St",
                    attendanceDate: "1990-01-01",
                },
                {
                    name: "Jane Smith",
                    phone: "234-567-8901",
                    email: "jane@example.com",
                    address: "456 Elm St",
                    attendanceDate: "1985-05-15",
                },
                {
                    name: "John Doe",
                    phone: "123-456-7890",
                    email: "john@example.com",
                    address: "123 Main St",
                    attendanceDate: "1990-01-01",
                },
                {
                    name: "Jane Smith",
                    phone: "234-567-8901",
                    email: "jane@example.com",
                    address: "456 Elm St",
                    attendanceDate: "1985-05-15",
                },
                {
                    name: "John Doe",
                    phone: "123-456-7890",
                    email: "john@example.com",
                    address: "123 Main St",
                    attendanceDate: "1990-01-01",
                },
                {
                    name: "Jane Smith",
                    phone: "234-567-8901",
                    email: "jane@example.com",
                    address: "456 Elm St",
                    attendanceDate: "1985-05-15",
                },
                {
                    name: "John Doe",
                    phone: "123-456-7890",
                    email: "john@example.com",
                    address: "123 Main St",
                    attendanceDate: "1990-01-01",
                },
                {
                    name: "Jane Smith",
                    phone: "234-567-8901",
                    email: "jane@example.com",
                    address: "456 Elm St",
                    attendanceDate: "1985-05-15",
                },
            ],
            currentPage: 1,
            pageSize: 10,
        };
    },
    computed: {
        totalPages() {
            return Math.ceil(this.filteredAttendances.length / this.pageSize);
        },
        paginatedContacts() {
            const startIndex = (this.currentPage - 1) * this.pageSize;
            return this.filteredAttendances.slice(
                startIndex,
                startIndex + this.pageSize
            );
        },
        availableDates() {
            // Extract unique dates from the attendances array
            const dates = this.attendances.map((a) => a.attendanceDate);
            return [...new Set(dates)]; // Remove duplicates
        },
        filteredAttendances() {
            if (!this.selectedDate) return [];
            return this.attendances.filter((attendance) => {
                return attendance.attendanceDate === this.selectedDate;
            });
        },
    },
    methods: {
        nextPage() {
            if (this.currentPage < this.totalPages) {
                this.currentPage++;
            }
        },
        prevPage() {
            if (this.currentPage > 1) {
                this.currentPage--;
            }
        },
    },
};
</script>

<style>
.date-select {
    margin-top: 10px;
    padding: 5px;
    font-size: 16px;
}

table {
    width: 100%;
    border-collapse: collapse;
}
h2 {
    text-align: center;
    margin-bottom: 30px;
}

th,
td {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
}

th {
    background-color: #f2f2f2;
}

.pagination {
    margin-top: 10px;
    display: flex;
    justify-content: center;
    align-items: center;
}

.pagination button {
    margin: 10px;
    cursor: pointer;
    border-radius: 8px;
}
</style>
