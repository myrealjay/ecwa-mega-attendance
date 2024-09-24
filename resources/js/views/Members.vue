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
        <div class="search-items">
            <input
                type="text"
                v-model="tableData.search"
                placeholder="Search members"
                class="search"
                @input="fetchData()"
            />

            <select class="form-control length-select" v-model="tableData.length" @change="fetchData()">
                <option v-for="item in lengthData" :value="item" :key="item">{{ item }}</option>
                <option v-if="tableData.total" :value="tableData.total">All</option>
            </select>
        </div>
       
        <table>
            <thead>
                <tr>
                    <th @click="sortBy('first_name')">Name</th>
                    <th @click="sortBy('phone_number')">Phone Number</th>
                    <th @click="sortBy('email')">Email</th>
                    <th @click="sortBy('address')">Address</th>
                    <th @click="sortBy('dob')">Date of Birth</th>
                </tr>
            </thead>
            <tbody>
                <tr
                    v-for=" contact in userData"
                    :key="contact.id"
                    @click="fetchContactDetails(contact.id)"
                    class="detail-click"
                >
                    <td>{{ contact.name }}</td>
                    <td>{{ contact.phone_number }}</td>
                    <td>{{ contact.email }}</td>
                    <td>{{ contact.address }}</td>
                    <td>{{ formatDate(contact.dob, true) }}</td>
                </tr>
            </tbody>
        </table>

        <Pagination
            :from="tableData.from"
            :to="tableData.to"
            :links="tableData.links"
            :total="tableData.total"
            @page-clicked="setPage"
        ></Pagination>

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

                    <FileField  
                        v-model="form.picture"
                        :error="
                            errors.picture ? errors.picture[0] : ''
                        " 
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
import Pagination from "../components/Pagination.vue";
import { mapState } from "vuex";
import FileField from "../components/FileField.vue"
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
                wedding_date: "",
                picture:""
            },
            errors: {},
            registerModalOpen: false,
            searchQuery: "",
            userData:[],
            lengthData:[
                5,10,20,30,40,50,100
            ],
            tableData:{
                search:'',
                currentPage:1,
                length:5,
                links:{},
                from:'',
                to:'',
                total:'',
                sort:'id',
                sort_direction:'ASC'
            }
        };
    },
    mounted() {
        this.fetchData();
    },
    computed: {
        
    },

    methods: {
        sortBy(field) {
            this.tableData.sort = field;
            if (this.tableData.sort_direction == 'ASC') {
                this.tableData.sort_direction = 'DESC';
            }
            else {
                this.tableData.sort_direction = 'ASC';
            }
            this.fetchData();
        },
        setPage(page) {
            this.tableData.currentPage = page;
            this.fetchData();
        },
        fetchData(url = this.endpoints.fetchUsers) {
            this.makeRequest('GET', `${url}?page=${this.tableData.currentPage}`, this.tableData).then(response=> {
                let data = response.data.data;
                this.tableData.currentPage = data.current_page;
                this.tableData.from = data.from;
                this.tableData.to = data.to;
                this.tableData.prevPage = data.prev_page_url;
                this.tableData.nextPage = data.next_page_url;
                this.tableData.links = data.links;
                this.tableData.total = data.total
                this.userData = data.data;
            }).catch(error => {
                console.log(error.response.data)
            })
        },
        showRegisterModal() {
            this.registerModalOpen = true;
        },

        register() {
            this.errors = {};
            let formData = new FormData();
            for(let item in this.form) {
                formData.append(item, this.form[item]);
            }
            this.showLoader();
            this.makeRequest("POST", this.endpoints.createUser, {}, formData)
                .then((response) => {
                    this.sweetAlert().success("Member Added successfully");
                    this.registerModalOpen = false;
                    this.form = {
                        first_name: "",
                        last_name: "",
                        email: "",
                        address: "",
                        dob: "",
                        phone_number: "",
                        wedding_date: "",
                    };

                    this.fetchData();
                })
                .catch((error) => {
                    this.sweetAlert().error("Error Registration");
                    console.log(error.response.data);
                })
                .finally(() => {
                    this.hideLoader();
                });
        },
        fetchContactDetails(contactId) {
            this.$router.push({ path: `/members/${contactId}` });
        },
    },
    components: {
        Button,
        Modal,
        TextField,
        EmailField,
        DateTimeField,
        Pagination,
        FileField
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
.detail-click {
    cursor: pointer;
}
.search {
    margin-bottom: 10px;
    padding: 10px;
    min-width: 40%;
}

.search-items{
    display: flex;
    justify-content: space-between;
}
.length-select {
    width:100px;
}
</style>
