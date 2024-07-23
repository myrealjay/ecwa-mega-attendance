<template>
    <div>
        <h2>Contacts</h2>
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
                    <td>{{ contact.phone }}</td>
                    <td>{{ contact.email }}</td>
                    <td>{{ contact.address }}</td>
                    <td>{{ contact.dob }}</td>
                </tr>
            </tbody>
        </table>

        <!-- Pagination controls -->
        <div class="pagination">
            <button @click="prevPage" :disabled="currentPage === 1">
                Previous
            </button>
            <span>Page {{ currentPage }} of {{ totalPages }}</span>
            <button @click="nextPage" :disabled="currentPage === totalPages">
                Next
            </button>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            contacts: [
                {
                    name: "John Doe",
                    phone: "123-456-7890",
                    email: "john@example.com",
                    address: "123 Main St",
                    dob: "1990-01-01",
                },
                {
                    name: "Jane Smith",
                    phone: "234-567-8901",
                    email: "jane@example.com",
                    address: "456 Elm St",
                    dob: "1985-05-15",
                },
                {
                    name: "John Doe",
                    phone: "123-456-7890",
                    email: "john@example.com",
                    address: "123 Main St",
                    dob: "1990-01-01",
                },
                {
                    name: "Jane Smith",
                    phone: "234-567-8901",
                    email: "jane@example.com",
                    address: "456 Elm St",
                    dob: "1985-05-15",
                },
                {
                    name: "John Doe",
                    phone: "123-456-7890",
                    email: "john@example.com",
                    address: "123 Main St",
                    dob: "1990-01-01",
                },
                {
                    name: "Jane Smith",
                    phone: "234-567-8901",
                    email: "jane@example.com",
                    address: "456 Elm St",
                    dob: "1985-05-15",
                },
                {
                    name: "John Doe",
                    phone: "123-456-7890",
                    email: "john@example.com",
                    address: "123 Main St",
                    dob: "1990-01-01",
                },
                {
                    name: "Jane Smith",
                    phone: "234-567-8901",
                    email: "jane@example.com",
                    address: "456 Elm St",
                    dob: "1985-05-15",
                },
                {
                    name: "John Doe",
                    phone: "123-456-7890",
                    email: "john@example.com",
                    address: "123 Main St",
                    dob: "1990-01-01",
                },
                {
                    name: "Jane Smith",
                    phone: "234-567-8901",
                    email: "jane@example.com",
                    address: "456 Elm St",
                    dob: "1985-05-15",
                },
                {
                    name: "John Doe",
                    phone: "123-456-7890",
                    email: "john@example.com",
                    address: "123 Main St",
                    dob: "1990-01-01",
                },
                {
                    name: "Jane Smith",
                    phone: "234-567-8901",
                    email: "jane@example.com",
                    address: "456 Elm St",
                    dob: "1985-05-15",
                },
                {
                    name: "John Doe",
                    phone: "123-456-7890",
                    email: "john@example.com",
                    address: "123 Main St",
                    dob: "1990-01-01",
                },
                {
                    name: "Jane Smith",
                    phone: "234-567-8901",
                    email: "jane@example.com",
                    address: "456 Elm St",
                    dob: "1985-05-15",
                },
            ],
            currentPage: 1,
            pageSize: 10,
        };
    },
    computed: {
        totalPages() {
            return Math.ceil(this.contacts.length / this.pageSize);
        },
        paginatedContacts() {
            const startIndex = (this.currentPage - 1) * this.pageSize;
            return this.contacts.slice(startIndex, startIndex + this.pageSize);
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
/* Add styling as per your preference */
table {
    width: 100%;
    border-collapse: collapse;
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
}

.pagination button {
    margin-right: 5px;
    cursor: pointer;
}
</style>
