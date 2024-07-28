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
            />
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
import { mapState, mapActions } from "vuex";
export default {
    data() {
        return {
            selectedDate: "",
            currentPage: 1,
            pageSize: 10,
        };
    },
    computed: {
        ...mapState(["attendantData"]),
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
            return Object.keys(this.attendantData || {});
        },
        filteredAttendances() {
            // Ensure that attendantData and the specific date entry exist
            if (
                !this.selectedDate ||
                !this.attendantData ||
                !this.attendantData[this.selectedDate]
            ) {
                return [];
            }
            const { present } = this.attendantData[this.selectedDate];
            return present
                ? present.map((p) => ({ ...p, status: "Present" }))
                : [];
        },
    },
    methods: {
        ...mapActions(["fetchAttendantData"]),
        fetchDataByDate() {
            if (this.selectedDate) {
                this.fetchAttendantData({ date: this.selectedDate });
            }
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
    },
    watch: {
        selectedDate(newDate) {
            this.fetchDataByDate();
        },
    },
    mounted() {
        if (this.selectedDate) {
            this.fetchDataByDate();
        }
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
