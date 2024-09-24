<template>
    <div>
        <div class="button-container">
            <Button
                text="ADD EMAIL TEMPLATE"
                color="primary"
                icon="mdi mdi-plus-box"
                @buttonClicked="showEmailTemplateModal()"
            ></Button>

            <select class="form-control select-legnth" name="" id="" v-model="tableData.length" @change="fetchTemplates()">
                <option v-for="item in lengthData" :key="item" :value="item">{{ item }}</option>
                <option v-if="paginationData.total" :value="paginationData.total">All</option>
            </select>
        </div>

        <div class="line"></div>
        <h2 class="head">Email Templates</h2>
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
            id="addEmailTemplate"
            title="Add Email Template"
            :open="emailTemplateOpen"
            @closed="emailTemplateOpen = false"
            :large="true"
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
                    v-model="emailTemplate.email_category_id"
                    text="name"
                    label="Category"
                ></SingleSelect>
                <editor
                    :init="{
                        height: 200,
                        menubar: false,
                        plugins: [
                            'advlist autolink lists link image charmap print preview anchor',
                            'searchreplace visualblocks code fullscreen',
                            'media table paste code help wordcount',
                        ],
                        toolbar:
                            'undo redo | formatselect | bold italic backcolor | \
                            alignleft aligncenter alignright alignjustify | \
                            bullist numlist outdent indent | removeformat | help',
                    }"
                    v-model="emailTemplate.template"
                />
            </div>
            <template #buttons>
                <Button
                    icon="mdi-book"
                    :text="edit ? 'Edit Template' : 'Submit Template'"
                    color="primary"
                    @buttonClicked="
                        edit ? editEmailTemplate() : addEmailTemplate()
                    "
                />
            </template>
        </Modal>
    </div>
</template>
<script>
import Button from "../components/Button.vue";
import Message from "../components/Message.vue";
import Editor from "@tinymce/tinymce-vue";
import SingleSelect from "../components/SingleSelect.vue";
import Modal from "../components/Modal.vue";
import Pagination from "../components/Pagination.vue";
export default {
    components: {
        Message,
        Button,
        editor: Editor,
        SingleSelect,
        Modal,
        Pagination,
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
            emailTemplate: {
                email_category_id: "",
                template: "",
            },
            categories: [],
            templates: [],
            paginationData: {},
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
            this.emailTemplate.template += attr;
        },
        setPage(page) {
            this.tableData.currentPage = page;
            this.fetchTemplates();
        },
        fetchTemplates() {
            this.makeRequest(
                "GET", 
                `${this.endpoints.fetchEmailTemplates}?page=${this.tableData.currentPage}`,
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
        showEmailTemplateModal() {
            this.emailTemplateOpen = true;
        },
        getAttributes() {
            let attributes = "";
            for (let value in this.userStructure) {
                attributes += `$${value}$ , `;
            }

            let attributeArray = attributes.split(',');

            return attributeArray;
        },
        addEmailTemplate() {
            this.showLoader();
            this.makeRequest(
                "POST",
                this.endpoints.createEmailTemplate,
                this.emailTemplate
            )
                .then((response) => {
                    this.sweetAlert().success(
                        "Email template successfully saved"
                    );
                    this.emailTemplateOpen = false;
                    this.emailTemplate = {
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
            this.emailTemplate = { ...template };
            this.emailTemplateOpen = true;
            this.edit = true;
        },
        editEmailTemplate() {
            this.showLoader();
            this.makeRequest(
                "PUT",
                `${this.endpoints.updateEmailTemplate}/${this.emailTemplate.id}`,
                this.emailTemplate
            )
                .then((response) => {
                    this.sweetAlert().success(
                        "Email template Edit successfully saved"
                    );
                    this.emailTemplateOpen = false;
                    this.emailTemplate = {
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
                    `${this.endpoints.deleteEmailTemplate}/${templateId}`
                )
                    .then((response) => {
                        this.sweetAlert().success(
                            "Template deleted successfully"
                        );
                        this.fetchTemplates(); // Refresh the list
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
    margin-top: 12px;
}
</style>
