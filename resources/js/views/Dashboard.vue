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
                text="ADD SMS TEMPLATE"
                color="secondary"
                icon="mdi mdi-plus-box"
                @buttonClicked="showSmsTemplateModal()"
            ></Button>
        </div>
       
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

export default {
    mounted() {
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
            errors: {},
            smsTemplateOpen: false,
            categories: [],
            smsTemplate: {
                email_category_id: "",
                template: "",
            },
            userStructure: {},
        };
    },
    methods: {
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
                })
                .catch((error) => {
                    this.sweetAlert().error("Error creating template");
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
        TextField,
        EmailField,
        DateTimeField,
        SingleSelect,
        TextAreaField,
    },
    computed: {
        currentUser() {
            return this.$store.state.currentUser;
        },
    }
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
