<template>
    <div>
        <div className="board_upper">
            <div>
                <h1>
                    Welcome back, {{ currentUser.first_name }}
                    <font-awesome-icon icon="fa-solid fa-hand" class="hand" />
                </h1>
                <p>
                    To register a new church member in the portal, please fill
                    out the required member details in the registration form and
                    click the 'Submit' button to complete the process.
                </p>
            </div>

            <div class="bible">
                <img src="../assets/images/church.jpg" alt="logo" />
            </div>
        </div>
        <div class="button-container">
            <Button
                text="ADD MEMBER"
                color="success"
                icon="mdi mdi-plus-circle"
                @buttonClicked="showRegisterModal()"
            ></Button>
            <Button
                text="ADD SMS TEMPLATE"
                color="secondary"
                icon="mdi mdi-plus-box"
                @buttonClicked="showSmsTemplateModal()"
            ></Button>
            <Button
                text="ADD EMAIL TEMPLATE"
                color="info"
                icon="mdi mdi-plus-box"
                @buttonClicked="showEmailTemplateModal()"
            ></Button>
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
                    <div class="mt-3">
                        <button
                            class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn"
                            @click.prevent="register()"
                        >
                            Register
                        </button>
                    </div>
                </form>
            </div>
        </Modal>
        <Modal
            id="addSmsTemplate"
            title="Add SMS Template"
            :open="smsTemplateOpen"
            @closed="smsTemplateOpen = false"
            :large="false"
        >
            <div>
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
                        height: 300,
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

<script lang="ts">
import Button from "../components/Button.vue";
import Modal from "../components/Modal.vue";
import TextField from "../components/TextField.vue";
import TextAreaField from "../components/TextAreaField.vue";
import EmailField from "../components/EmailField.vue";
import DateTimeField from "../components/DateTimeField.vue";
import SingleSelect from "../components/SingleSelect.vue";
import Editor from "@tinymce/tinymce-vue";

export default {
    mounted() {
        this.makeRequest("GET", this.endpoints.userStructure)
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
    },
    data() {
        return {
            form: {
                first_name: "",
                last_name: "",
                email: "",
                address: "",
                dob: "",
                phone_number: "",
            },
            errors: {},
            registerModalOpen: false,
            smsTemplateOpen: false,
            emailTemplateOpen: false,
            categories: [],
            emailTemplate: {
                email_category_id: "",
                template: "",
            },
            smsTemplate: {
                email_category_id: "",
                template: "",
            },
            userStructure: {},
        };
    },
    methods: {
        register() {
            this.errors = {};
            this.showLoader();
            this.makeRequest("POST", this.endpoints.createUser, {}, this.form)
                .then((response) => {
                    this.sweetAlert().success(
                        "Registration template successfully saved"
                    );
                    this.registerModalOpen = false;
                    this.form = {
                        first_name: "",
                        last_name: "",
                        email: "",
                        address: "",
                        dob: "",
                        phone_number: "",
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
        showRegisterModal() {
            this.registerModalOpen = true;
        },
        showSmsTemplateModal() {
            this.smsTemplateOpen = true;
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
                })
                .catch((error) => {
                    this.sweetAlert().error("Error creating template");
                    console.log(error.response.data);
                })
                .finally(() => {
                    this.hideLoader();
                });
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
                })
                .catch((error) => {
                    this.sweetAlert().error("Error creating template");
                    console.log(error.response.data);
                })
                .finally(() => {
                    this.hideLoader();
                });
        },
    },
    components: {
        Button,
        Modal,
        TextField,
        EmailField,
        DateTimeField,
        SingleSelect,
        editor: Editor,
        TextAreaField,
    },
    computed: {
        currentUser() {
            return this.$store.state.currentUser;
        },
    },
    created() {
        this.$store.dispatch("fetchContactData");
    },
};
</script>

<style scoped>
.container-fluid {
    background: url(../assets/images/ecwa.png);
    background-repeat: no-repeat;
    background-size: cover;
    background-position: center;
}
.content-wrapper {
    background-color: rgba(0, 0, 0, 0.7);
}
.font-weight-dark {
    color: rgb(111, 108, 108);
}
.auth-form-light > h4 {
    font-size: 28px;
}
h4 {
    text-align: center;
}
.brand-logo {
    display: flex;
    justify-content: center;
}
.error {
    color: #ff0000;
    text-align: center;
}
.board_upper {
    display: flex;
    justify-content: space-between;
    padding: 20px;
    background-color: #073883;
    color: #fff;
    border-radius: 16px;
    margin-bottom: 20px;
}
.line {
    height: 5px;
    background-color: #073883;
    margin-bottom: 15px;
}
.board_upper > div > h1 {
    text-align: left;
    font-size: 50px;
    font-weight: 700;
    text-transform: capitalize;
}
.board_upper > div > p {
    color: #e7bebe;
}
.hand {
    color: gold;
}
.bible > img {
    background-color: #073883;
    width: 90%;
    height: 80%;
    border-radius: 8px;
}
@media screen and (max-width: 900px) {
    .board_upper {
        padding: 10px;
    }
    .board_upper > h1 {
        font-size: 20px;
        word-wrap: break-word;
    }
}
</style>
