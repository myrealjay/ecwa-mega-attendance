<template>
    <div>
        <div class="button-container">
            <Button
                text="ADD MEMBER"
                color="primary"
                icon="mdi mdi-plus-circle"
                @buttonClicked="showRegisterModal()"
            ></Button>
        </div>
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

        <Modal
            id="registerModal"
            title="Register Church Member"
            :open="registerModalOpen"
            @closed="registerModalOpen = false"
            :large="false"
        >
            <div>
                <div class="line"></div>
                <form class="pt-3">
                    <TextField
                        label="First Name"
                        v-model="form.first_name"
                        :error="errors.first_name ? errors.first_name[0] : ''"
                    />
                    <TextField
                        label="Last Name"
                        v-model="form.last_name"
                        :error="errors.last_name ? errors.last_name[0] : ''"
                    />
                    <TextField
                        label="Phone Number"
                        v-model="form.phone_number"
                        :error="
                            errors.phone_number ? errors.phone_number[0] : ''
                        "
                    />
                    <TextField
                        label="Home Address"
                        v-model="form.address"
                        :error="errors.address ? errors.address[0] : ''"
                    />
                    <EmailField
                        label="Email"
                        v-model="form.email"
                        :error="errors.email ? errors.email[0] : ''"
                    />
                    <DateTimeField
                        label="DOB"
                        v-model="form.dob"
                        :error="errors.dob ? errors.dob[0] : ''"
                    />

                    <DateTimeField
                        label="Wedding Date"
                        v-model="form.wedding_date"
                        :error="errors.wedding_date ? errors.wedding_date[0] : ''"
                    />
                </form>
            </div>
            <template #buttons>
                <Button
                    icon="mdi-send"
                    text="Register"
                    color="primary"
                    @buttonClicked="register()"
                />
            </template>
        </Modal>
    </div>
</template>

<script>
import Button from "../components/Button.vue";
import Modal from "../components/Modal.vue";
import TextField from "../components/TextField.vue";
import EmailField from "../components/EmailField.vue";
import DateTimeField from "../components/DateTimeField.vue";
import { mapState } from "vuex";
export default {
    data() {
        return {
            currentPage: 1,
            pageSize: 10,
            form: {
                first_name: "",
                last_name: "",
                email: "",
                address: "",
                dob: "",
                phone_number: "",
                wedding_date:''
            },
            errors: {},
            registerModalOpen: false,
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
        showRegisterModal() {
            this.registerModalOpen = true;
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

        register() {
            this.errors = {};
            this.showLoader();
            this.makeRequest("POST", this.endpoints.createUser, {}, this.form)
                .then((response) => {
                    this.sweetAlert().success(
                        "Member Added successfully"
                    );
                    this.$store.dispatch("fetchContactData");
                    this.registerModalOpen = false;
                    this.form = {
                        first_name: "",
                        last_name: "",
                        email: "",
                        address: "",
                        dob: "",
                        phone_number: "",
                        wedding_date:''
                    };
                })
                .catch((error) => {
                    this.sweetAlert().error("Error Registration");
                    console.log(error.response.data);
                })
                .finally(() => {
                    this.hideLoader();
                });
        },
    },
    created() {
        this.$store.dispatch("fetchContactData");
    },
    components: {
        Button,
        Modal,
        TextField,
        EmailField,
        DateTimeField,
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
