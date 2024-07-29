<template>
    <div>
        <div class="button-container">
            <Button
                text="ADD EMAIL TEMPLATE"
                color="info"
                icon="mdi mdi-plus-box"
                @buttonClicked="showEmailTemplateModal()"
            ></Button>
        </div>

        <div class="line"></div>
        <h2 class="head">Email Templates</h2>
        <div class="messages">
            <Message v-for="template in templates" :key="template.id"
                :message="template.template"
                :category="'Category:' + template.category ? template.category.name:'' "
            />
           
        </div>

        <Pagination 
            :from="paginationData.from" 
            :to="paginationData.to"
            :links="paginationData.links"
            :total="paginationData.total"
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
                    <b>You can use any of these attributes:</b><br />{{
                        getAttributes()
                    }}
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
                    text="Submit Template"
                    color="primary"
                    @buttonClicked="addEmailTemplate()"
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
    components: { Message, Button, editor:Editor, SingleSelect, Modal , Pagination},
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
            templates:[],
            paginationData:{}
        }
    },
    methods: {
        fetchTemplates() {
            this.makeRequest('GET', this.endpoints.fetchEmailTemplates).then(response => {
                this.templates = response.data.data.data;
                this.paginationData = response.data.data;
            }).catch(error => {
                console.log(error.response.data)
            })
        },
        showEmailTemplateModal() {
            this.emailTemplateOpen = true;
        },
        getAttributes() {
            let attributes = "";
            for (let value in this.userStructure) {
                attributes += `$${value}$ , `;
            }

            return attributes;
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
    }
};
</script>
<style>
.messages {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr;
    grid-gap: 10px;
}
.head {
    text-align: center;
    font-weight: bold;
}
</style>
