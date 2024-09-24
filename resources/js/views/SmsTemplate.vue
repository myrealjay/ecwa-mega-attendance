<template>
    <div>
        <div class="button-container">
            <Button
                aria-label="Attendance for last 4 Sundays"
                text="ADD SMS TEMPLATE"
                color="primary"
                icon="mdi mdi-plus-box"
                @buttonClicked="showSmsTemplateModal()"
            ></Button>

            <select class="form-control select-legnth" name="" id="" v-model="tableData.length" @change="fetchTemplates()">
                <option v-for="item in lengthData" :key="item" :value="item">{{ item }}</option>
                <option v-if="paginationData.total" :value="paginationData.total">All</option>
            </select>
        </div>

        <div class="line"></div>
        <h2 class="head">SMS Templates</h2>
        <div class="messages">
            <Message
                v-for="template in templates"
                :key="template.id"
                :message="template.template"
                :category="
                    'Category:' + template.category
                        ? template.category.name
                        : ''
                "
            >
                <template #actions>
                    <button @click="editTemplate(template)">Edit</button>
                    <button @click="deleteTemplate(template.id)">Delete</button>
                </template>
            </Message>
        </div>

        <Pagination
            :from="paginationData.from"
            :to="paginationData.to"
            :links="paginationData.links"
            :total="paginationData.total"
            @page-clicked="setPage"
        />

        <Modal
            id="addSmsTemplate"
            title="Add SMS Template"
            :open="smsTemplateOpen"
            @closed="smsTemplateOpen = false"
            :large="false"
        >
            <div>
                <div>
                    <b>You can use any of these attributes:</b><br />
                    <button 
                        class="btn btn-info" v-for="attr in getAttributes()" 
                        style="margin: 2px;"
                        :key="attr"
                        @click="addAttribute(attr)"
                    >
                        {{ attr }}
                    </button>
                </div>
                <div class="line"></div>
                <SingleSelect
                    :options="categories"
                    custom_value="id"
                    v-model="smsTemplate.email_category_id"
                    text="name"
                    label="Category"
                ></SingleSelect>
                <TextAreaField
                    label="Message"
                    v-model="smsTemplate.template"
                    rows="10"
                    placeholder="Enter SMS Template..."
                />
            </div>
            <template #buttons>
                <Button
                    icon="mdi-book"
                    :text="edit ? 'Edit Template' : 'Submit Template'"
                    color="primary"
                    @buttonClicked="edit ? editSmsTemplate() : addSmsTemplate()"
                />
            </template>
        </Modal>
    </div>
</template>
<script>
import Button from "../components/Button.vue";
import Message from "../components/Message.vue";
import SingleSelect from "../components/SingleSelect.vue";
import Modal from "../components/Modal.vue";
import Pagination from "../components/Pagination.vue";
import TextAreaField from "../components/TextAreaField.vue";
export default {
    components: {
        Message,
        Button,
        SingleSelect,
        Modal,
        Pagination,
        TextAreaField,
    },
    mounted() {
        this.makeRequest("GET", this.endpoints.userStructre)
            .then((response) => {
                this.userStructure = response.data.data;
            })
            .catch((error) => {
                console.log(error.response.data);
            });

        this.makeRequest("GET", this.endpoints.getCategories)
            .then((response) => {
                this.categories = response.data.data;
            })
            .catch((error) => {
                console.log(error.response);
            });

        this.fetchTemplates();
    },
    data() {
        return {
            emailTemplateOpen: false,
            userStructure: {},
            smsTemplate: {
                email_category_id: "",
                template: "",
            },
            categories: [],
            templates: [],
            paginationData: {},
            smsTemplateOpen: false,
            edit: false,
            tableData:{
                length:15,
                currentPage:1
            },
            lengthData:[10,15,20,30,40,50,100]
        };
    },
    methods: {
        addAttribute(attr) {
            this.smsTemplate.template += attr;
        },
        setPage(page) {
            this.tableData.currentPage = page;
            this.fetchTemplates();
        },
        fetchTemplates() {
            this.makeRequest(
                "GET", 
                `${this.endpoints.fetchSmsTemplates}?page=${this.tableData.currentPage}`,
                this.tableData
            )
                .then((response) => {
                    this.templates = response.data.data.data;
                    this.paginationData = response.data.data;
                })
                .catch((error) => {
                    console.log(error.response.data);
                });
        },
        showSmsTemplateModal() {
            this.smsTemplateOpen = true;
        },
        getAttributes() {
            let attributes = "";
            for (let value in this.userStructure) {
                attributes += `$${value}$ , `;
            }

            let attributeArray = attributes.split(',');

            return attributeArray;
        },
        addSmsTemplate() {
            this.showLoader();
            this.makeRequest(
                "POST",
                this.endpoints.createSmsTemplate,
                this.smsTemplate
            )
                .then((response) => {
                    this.sweetAlert().success(
                        "SMS template successfully saved"
                    );
                    this.smsTemplateOpen = false;
                    this.smsTemplate = {
                        email_category_id: "",
                        template: "",
                    };
                    this.fetchTemplates();
                })
                .catch((error) => {
                    this.sweetAlert().error("Error creating template");
                    console.log(error.response.data);
                })
                .finally(() => {
                    this.hideLoader();
                });
        },
        editTemplate(template) {
            this.smsTemplate = { ...template };
            this.smsTemplateOpen = true;
            this.edit = true;
        },
        editSmsTemplate() {
            this.showLoader();
            this.makeRequest(
                "PUT",
                `${this.endpoints.updateSmsTemplate}/${this.smsTemplate.id}`,
                this.smsTemplate
            )
                .then((response) => {
                    this.sweetAlert().success(
                        "Sms template Edit successfully saved"
                    );
                    this.smsTemplateOpen = false;
                    this.smsTemplate = {
                        email_category_id: "",
                        template: "",
                    };
                    this.edit = false;
                    this.fetchTemplates();
                })
                .catch((error) => {
                    this.sweetAlert().error("Error editing template");
                    console.log(error.response.data);
                })
                .finally(() => {
                    this.hideLoader();
                });
        },
        deleteTemplate(templateId) {
            if (confirm("Are you sure you want to delete this template?")) {
                this.makeRequest(
                    "DELETE",
                    `${this.endpoints.deleteSmsTemplate}/${templateId}`
                )
                    .then((response) => {
                        this.sweetAlert().success(
                            "Template deleted successfully"
                        );
                        this.fetchTemplates();
                    })
                    .catch((error) => {
                        this.sweetAlert().error("Error deleting template");
                        console.log(error.response.data);
                    });
            }
        },
    },
};
</script>
<style>
.messages {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr;
    grid-gap: 10px;
    overflow: auto;
}
.head {
    text-align: center;
    font-weight: bold;
}
.select-legnth {
    width: 100px;
}
</style>
