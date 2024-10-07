<template>
    <div>
        <div class="button-container"></div>

        <div class="line"></div>
        <h2 class="head">Send Custom Messages</h2>

        <div>
            <div>
                <TextAreaField label="Emails" v-model="message.emails" />
                <TextAreaField
                    label="Phone Numbers"
                    v-model="message.phoneNumbers"
                />

                <TextAreaField
                    label="Test Message"
                    v-model="message.textMessage"
                />
                <label for="">Text Count: {{ textCount }}</label>
            </div>

            <label for="">Mail Message</label>

            <TextField 
                label="Subject"
                v-model="message.subject"
            />
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
                @input="checkLength()"
                v-model="message.mailMessage"
            />

            <div>
                <br />
                <Button
                    icon="mdi-book"
                    text="Send Message"
                    color="primary"
                    @buttonClicked="sendMessage()"
                />
            </div>
        </div>
    </div>
</template>
<script>
import Button from "../components/Button.vue";
import Editor from "@tinymce/tinymce-vue";
import TextAreaField from "../components/TextAreaField.vue";
import TextField from "../components/TextField.vue";
export default {
    components: {
        Button,
        editor: Editor,
        TextAreaField,
        TextField
    },
    mounted() {},
    data() {
        return {
            message: {
                mailMessage: "",
                emails: "",
                subject:'',
                phoneNumbers: "",
                textMessage:""
            },
        };
    },
    computed: {
        textCount() {
            let count = this.message.textMessage.length;
            return count;
        }
    },
    methods: {
        sendMessage() {
            this.showLoader();
            this.makeRequest(
                "POST",
                this.endpoints.sendCustomEmails,
                this.message
            )
                .then((response) => {
                    this.sweetAlert().success("Message sent successfully");

                    this.message = {
                        mailMessage: "",
                        emails: "",
                        phoneNumbers: "",
                        textMessage:"",
                        subject:""
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
