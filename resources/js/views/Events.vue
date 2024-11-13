<template>
    <div>
        <div class="button-container">
            <Button
                text="ADD EVENT"
                color="primary"
                icon="mdi mdi-plus-circle"
                @buttonClicked="showEventModal()"
            ></Button>
        </div>
        <h2>CHURCH EVENTS</h2>
        <div class="search-items">
            <select class="form-control length-select" v-model="tableData.length" @change="fetchData()">
                <option v-for="item in lengthData" :value="item" :key="item">{{ item }}</option>
                <option v-if="tableData.total" :value="tableData.total">All</option>
            </select>
        </div>

        <table>
            <thead>
                <tr>
                    <th @click="sortBy('first_name')">Event Image Url</th>
                    <th>Date Uploaded</th>
                    <th >Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr
                    v-for=" event in userData"
                    :key="event.id"
                    class="detail-click"
                >
                    <td>{{ event.url}}</td>
                    <td>{{ formatDate(event.created_at, true) }}</td>
                    <td><button @click.prevent="deleteEvent(event)" class="btn btn-danger">X</button></td>
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
            title="Add Event"
            :open="registerModalOpen"
            @closed="registerModalOpen = false"
            :large="false"
        >
            <div>
                <h4>Upload a 1500 X 500 image</h4>
                <div class="line"></div>
                <form class="pt-3">
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
                    text="Upload"
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
import Pagination from "../components/Pagination.vue";
import FileField from "../components/FileField.vue"
export default {
    data() {
        return {
            currentPage: 1,
            pageSize: 10,
            form: {
                picture:""
            },
            errors: {},
            registerModalOpen: false,
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
        deleteEvent(event) {
            if (confirm("Are you sure you want to delete this event?")) {
                this.makeRequest("POST", `${this.endpoints.deleteEvent}/${event.id}`, {}, {})
                .then((response) => {
                    this.sweetAlert().success("Event Deleted successfully");

                    this.fetchData();
                })
                .catch((error) => {
                    this.sweetAlert().error("Error Deleting event");
                    console.log(error.response.data);
                })
                .finally(() => {
                    this.hideLoader();
                });
            }
        },
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
        fetchData(url = this.endpoints.fetchEvent) {
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
        showEventModal() {
            this.registerModalOpen = true;
        },

        register() {
            this.errors = {};
            let formData = new FormData();
            for(let item in this.form) {
                formData.append(item, this.form[item]);
            }
            this.showLoader();
            this.makeRequest("POST", this.endpoints.uploadEvent, {}, formData)
                .then((response) => {
                    this.sweetAlert().success("Event Added successfully");
                    this.registerModalOpen = false;
                    this.form = {
                        picture:''
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
        }
    },
    components: {
        Button,
        Modal,
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
