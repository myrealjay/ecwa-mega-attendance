<template>
    <div class="login">
        <div class="container-scroller">
            <div class="container-fluid page-body-wrapper full-page-wrapper">
                <div
                    class="content-wrapper d-flex align-items-center auth px-0"
                >
                    <div class="row w-100 mx-0">
                        <div class="col-lg-4 mx-auto">
                            <div
                                class="auth-form-light text-left py-5 px-4 px-sm-5"
                            >
                                <div class="brand-logo">
                                    <img
                                        src="../assets/images/megalogo.jpg"
                                        alt="logo"
                                    />
                                </div>
                                <h4>Add Message</h4>
                                <form class="pt-3">
                                    <TextField
                                        label="Title"
                                        v-model="form.title"
                                        :error="
                                            errors.title ? errors.title[0] : ''
                                        "
                                    />

                                    <TextAreaField
                                        label="Message"
                                        v-model="form.message"
                                        :error="
                                            errors.message
                                                ? errors.message[0]
                                                : ''
                                        "
                                    />
                                    <Select
                                        label="Choose an option"
                                        :options="selectOptions"
                                        @selection-changed="handleSelection"
                                    />

                                    <div class="mt-3">
                                        <button
                                            class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn"
                                            @click.prevent="register()"
                                        >
                                            Register
                                        </button>
                                    </div>
                                    <div
                                        class="text-center mt-4 font-weight-dark"
                                    >
                                        Go Back To Home
                                        <a
                                            @click.prevent="
                                                $router.push({
                                                    name: 'dashboard',
                                                })
                                            "
                                            href=""
                                            class="text-primary"
                                            >Home</a
                                        >
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script lang="ts">
import TextField from "../components/TextField.vue";
import TextAreaField from "../components/TextAreaField.vue";
import Select from "../components/Select.vue";

export default {
    data() {
        return {
            form: {
                title: "",
                message: "",
                category: "",
            },
            errors: {},
            selectOptions: [
                { text: "Birthday", value: "birthday" },
                { text: "Absent", value: "absent" },
                { text: "Present", value: "Present" },
            ],
        };
    },
    methods: {
        handleSelection(value) {
            this.category = value;
        },
        register() {
            this.errors = {};
            this.showLoader();
            this.makeRequest("POST", this.endpoints.message, {}, this.form)
                .then((response) => {
                    this.hideLoader();
                    this.$router.push({
                        name: "home",
                        query: { action: "new" },
                    });
                })
                .catch((error) => {
                    this.hideLoader();
                    if (error.response) {
                        if (!error.response.data.data) {
                            this.sweetAlert().error(
                                error.response.data.message
                            );
                        } else {
                            this.errors = error.response.data.data;
                        }
                    } else {
                        this.sweetAlert().error(error);
                    }
                });
        },
    },
    components: { TextField, TextAreaField, Select },
};
</script>
<style scoped>
h4 {
    text-align: center;
}
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
.brand-logo {
    display: flex;
    justify-content: center;
}
.error {
    color: #ff0000;
    text-align: center;
}
</style>
