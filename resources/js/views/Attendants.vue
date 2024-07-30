<template>
    <div>
        <h2>Attendance by Date</h2>
        <div>
            <label for="date-select">Select Date:</label>
            <input
                id="date-select"
                type="date"
                v-model="selectedDate"
                class="date-select"
                @change="fetchDataByDate"
            />
        </div>
        <div v-if="presentAttendees.length > 0" class="attendance-list">
            <h3>Present Member on {{ selectedDate }}</h3>
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
                        v-for="(contact, index) in paginatedPresent"
                        :key="index"
                    >
                        <td>{{ contact.name }}</td>
                        <td>{{ contact.phone_number }}</td>
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
                <span class="pages">
                    Page {{ currentPage }} of {{ totalPages }}
                </span>
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
            <p>No present attendees recorded for the selected date.</p>
        </div>
        <div v-if="absentAttendees.length > 0" class="attendance-list">
            <h3>Absent Member on{{ selectedDate }}</h3>
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
                        v-for="(contact, index) in paginatedAbsent"
                        :key="index"
                    >
                        <td>{{ contact.name }}</td>
                        <td>{{ contact.phone_number }}</td>
                        <td>{{ contact.email }}</td>
                        <td>{{ contact.address }}</td>
                    </tr>
                </tbody>
            </table>
            <div class="pagination">
                <button
                    @click="prevPageAbsent"
                    :disabled="currentPageAbsent === 1"
                    class="previous"
                >
                    Previous
                </button>
                <span class="pages">
                    Page {{ currentPageAbsent }} of {{ totalPagesAbsent }}
                </span>
                <button
                    @click="nextPageAbsent"
                    :disabled="currentPageAbsent === totalPagesAbsent"
                    class="next"
                >
                    Next
                </button>
            </div>
        </div>
        <div v-else>
            <p>No absent attendees recorded for the selected date.</p>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            selectedDate: "",
            currentPage: 1,
            currentPageAbsent: 1,
            pageSize: 10,
            presentAttendees: [],
            absentAttendees: [],
        };
    },
    computed: {
        totalPages() {
            return Math.ceil(this.presentAttendees.length / this.pageSize);
        },
        totalPagesAbsent() {
            return Math.ceil(this.absentAttendees.length / this.pageSize);
        },
        paginatedPresent() {
            const startIndex = (this.currentPage - 1) * this.pageSize;
            return this.presentAttendees.slice(
                startIndex,
                startIndex + this.pageSize
            );
        },
        paginatedAbsent() {
            const startIndex = (this.currentPageAbsent - 1) * this.pageSize;
            return this.absentAttendees.slice(
                startIndex,
                startIndex + this.pageSize
            );
        },
    },
    methods: {
        fetchDataByDate() {
            this.makeRequest(
                "GET",
                `${this.endpoints.fetchAttendanceByDate}?date=${this.selectedDate}`
            )
                .then((response) => {
                    this.presentAttendees = response.data.data.present;
                    this.absentAttendees = response.data.data.absent;
                })
                .catch((error) => {
                    console.log(error.response.data);
                });
        },
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
        nextPageAbsent() {
            if (this.currentPageAbsent < this.totalPagesAbsent) {
                this.currentPageAbsent++;
            }
        },
        prevPageAbsent() {
            if (this.currentPageAbsent > 1) {
                this.currentPageAbsent--;
            }
        },
    },
};
</script>

<style>
.date-select {
    margin-top: 10px;
    margin-bottom: 20px;
    padding: 5px;
    font-size: 16px;
    border-radius: 8px;
}
.date-select:focus {
    border: none;
}

table {
    width: 100%;
    border-collapse: collapse;
}
h2,
h3 {
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
