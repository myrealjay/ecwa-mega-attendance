<template>
    <div>
        <h2>LIST OF ALL CHURCH MEMBER</h2>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Phone Number</th>
                    <th>Email</th>
                    <th>Address</th>
                    <th>Date of Birth</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(contact, index) in paginatedContacts" :key="index">
                    <td>{{ contact.name }}</td>
                    <td>{{ contact.phone_number }}</td>
                    <td>{{ contact.email }}</td>
                    <td>{{ contact.address }}</td>
                    <td>{{ contact.dob }}</td>
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
</template>

<script>
import { mapState } from "vuex";
export default {
    data() {
        return {
            currentPage: 1,
            pageSize: 10,
        };
    },
    computed: {
        totalPages() {
            return Math.ceil(this.contactData.length / this.pageSize);
        },
        paginatedContacts() {
            const startIndex = (this.currentPage - 1) * this.pageSize;
            return this.contactData.slice(
                startIndex,
                startIndex + this.pageSize
            );
        },
        ...mapState(["contactData"]),
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
