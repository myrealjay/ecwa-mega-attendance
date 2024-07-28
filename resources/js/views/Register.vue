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
                                <h4>Register Church Member</h4>
                                <form class="pt-3">
                                    <TextField
                                        label="First Name"
                                        v-model="form.first_name"
                                        :error="
                                            errors.first_name
                                                ? errors.first_name[0]
                                                : ''
                                        "
                                    />

                                    <TextField
                                        label="Last Name"
                                        v-model="form.last_name"
                                        :error="
                                            errors.last_name
                                                ? errors.last_name[0]
                                                : ''
                                        "
                                    />

                                    <TextField
                                        label="Phone Number"
                                        v-model="form.phone_number"
                                        :error="
                                            errors.phone_number
                                                ? errors.phone_number[0]
                                                : ''
                                        "
                                    />
                                    <TextField
                                        label="Home Address"
                                        v-model="form.address"
                                        :error="
                                            errors.address
                                                ? errors.address[0]
                                                : ''
                                        "
                                    />

                                    <EmailField
                                        label="Email"
                                        v-model="form.email"
                                        :error="
                                            errors.email ? errors.email[0] : ''
                                        "
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
                <!-- content-wrapper ends -->
            </div>
            <!-- page-body-wrapper ends -->
        </div>
    </div>
</template>

<script lang="ts">
import TextField from "../components/TextField.vue";
import EmailField from "../components/EmailField.vue";

import DateTimeField from "../components/DateTimeField.vue";
export default {
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
        };
    },
    methods: {
        register() {
            this.errors = {};
            this.showLoader();
            this.makeRequest("POST", this.endpoints.createUser, {}, this.form)
                .then((response) => {
                    this.hideLoader();
                    this.$router.push({
                        name: "dashboard",
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
    components: { TextField, EmailField, DateTimeField },
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
</style>
