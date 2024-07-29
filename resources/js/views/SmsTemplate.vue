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
        </div>

        <div class="line"></div>
        <h2 class="head">SMS Templates</h2>
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
            id="addSmsTemplate"
            title="Add SMS Template"
            :open="smsTemplateOpen"
            @closed="smsTemplateOpen = false"
            :large="false"
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
                    text="Submit Template"
                    color="primary"
                    @buttonClicked="addSmsTemplate()"
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
    components: { Message, Button, SingleSelect, Modal , Pagination, TextAreaField},
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
            templates:[],
            paginationData:{},
            smsTemplateOpen: false,
        }
    },
    methods: {
        fetchTemplates() {
            this.makeRequest('GET', this.endpoints.fetchSmsTemplates).then(response => {
                this.templates = response.data.data.data;
                this.paginationData = response.data.data;
            }).catch(error => {
                console.log(error.response.data)
            })
        },
        showSmsTemplateModal() {
            this.smsTemplateOpen = true;
        },
        getAttributes() {
            let attributes = "";
            for (let value in this.userStructure) {
                attributes += `$${value}$ , `;
            }

            return attributes;
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
        }
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
