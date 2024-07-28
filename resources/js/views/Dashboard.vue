<template>
    <div>
        <div className="board_upper">
            <div>
                <h1>
                    Welcome back, {{ currentUser.first_name }}
                    <font-awesome-icon icon="fa-solid fa-hand " class="hand" />
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
                @buttonClicked="$router.push({ name: 'register' })"
            ></Button>
            <Button
                text="ADD SMS TEMPLATE"
                color="secondary"
                icon="mdi mdi-plus-box"
                @buttonClicked="$router.push({ name: 'message' })"
            ></Button>

            <Button
                text="ADD EMAIL TEMPLATE"
                color="info"
                icon="mdi mdi-plus-box"
                @buttonClicked="showEmailTemplateModal()"
            ></Button>
        </div>

        <Modal id="addEmailTemplate" 
            title="Add Email template" 
            :open="emailTemplateOpen"
            @closed="emailTemplateOpen = false"
            :large="true"
        >

            <div>
                <SingleSelect 
                :options="categories" 
                custom_value="id" v-model="emailTemplate.email_category_id"
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
                        'media table paste code help wordcount'
                        ],
                        toolbar:
                        'undo redo | formatselect | bold italic backcolor | \
                        alignleft aligncenter alignright alignjustify | \
                        bullist numlist outdent indent | removeformat | help'
                    }"

                    v-model="emailTemplate.template"
                />
            </div>
            <template #buttons>
                <Button icon="mdi-book" 
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
import Modal from "../components/Modal.vue"
import SingleSelect from "../components/SingleSelect.vue";
import Editor from '@tinymce/tinymce-vue'

export default {
    components: { Button, Modal , SingleSelect, 'editor': Editor},
    mounted() {
        this.makeRequest('GET', this.endpoints.getCategories)
        .then(response => {
            this.categories = response.data.data;
        }).catch(error => {
            console.log(error.response)
        })
    },
    data() {
        return {
            emailTemplateOpen: false,
            categories:[],
            emailTemplate:{
                email_category_id:'',
                template:''
            }
        };
    },
    methods: {
        showEmailTemplateModal() {
            this.emailTemplateOpen = true
        },
        addEmailTemplate() {
            this.showLoader();
            this.makeRequest('POST', this.endpoints.createEmailTemplate, this.emailTemplate).then(response => {
                this.sweetAlert().success('Email template successfully saved');
                this.emailTemplateOpen = false;
                this.emailTemplate = {
                    email_category_id:'',
                    template:''
                }
            }).catch(error => {
                this.sweetAlert().error('Error creating template');
                console.log(error.response.data)
            }).finally(() => {
                this.hideLoader();
            })
        }

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
.board_upper {
    display: flex;
    justify-content: space-between;
    padding: 20px;
    background-color: #073883;
    color: #fff;
    border-radius: 16px;
    margin-bottom: 20px;
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
