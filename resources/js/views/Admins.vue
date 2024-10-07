<template>
    <div>
        <div class="button-container">
            <Button
                text="ADD ADMIN"
                color="primary"
                icon="mdi mdi-plus-circle"
                @buttonClicked="showRegisterModal()"
            ></Button>
        </div>
        <h2>LIST OF ALL ADMINS</h2>
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
                    <th @click="sortBy('email')">Email</th>
                    <th @click="sortBy('address')">Roles</th>
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
                    <td>{{ contact.email }}</td>
                    <td><div class="btn btn-info" v-for="role in contact.roles">{{ role.name }}</div></td>
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
            title="Add Admin"
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
                    <EmailField
                        label="Email"
                        v-model="form.email"
                        :error="errors.email ? errors.email[0] : ''"
                    />
                    <SingleSelect
                        :options="gender"
                        label="Gender"
                        custom_value="name"
                        v-model="form.gender"
                        text="name"
                    ></SingleSelect>

                    <SingleSelect
                        :options="roles"
                        label="Role"
                        custom_value="name"
                        v-model="form.role"
                        text="name"
                    ></SingleSelect>
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
import FileField from "../components/FileField.vue"
import SingleSelect from "../components/SingleSelect.vue";
export default {
    data() {
        return {
            currentPage: 1,
            pageSize: 10,
            gender:[
                {name: 'Male'},
                {name: 'Female'}
            ],
            form: {
                first_name: "",
                last_name: "",
                email: "",
                gender: "",
                role:''
            },
            errors: {},
            registerModalOpen: false,
            searchQuery: "",
            userData:[],
            lengthData:[
                5,10,20,30,40,50,100
            ],
            roles:[],
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

        this.makeRequest('GET', this.endpoints.fetchRoles).then(response => {
            this.roles = response.data.data;
        }).catch(error => {
            console.log(error.response);
        })

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
        fetchData(url = this.endpoints.fetchAdmins) {
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
            this.makeRequest("POST", this.endpoints.addAdmin, {}, formData)
                .then((response) => {
                    if (response.data.status == 200) {
                        this.sweetAlert().success("Admin Added successfully");
                        this.registerModalOpen = false;
                        this.form = {
                            first_name: "",
                            last_name: "",
                            email: "",
                            gender:'',
                            role:''
                        };
                    } else {
                        this.sweetAlert().error(response.data.message);
                    }
                    
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
            //this.$router.push({ path: `/admins/${contactId}` });
        },
    },
    components: {
        Button,
        Modal,
        TextField,
        EmailField,
        DateTimeField,
        Pagination,
        FileField,
        SingleSelect
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
