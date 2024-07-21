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
                                        src="../assets/images/ecwalogo.jpg"
                                        alt="logo"
                                        style="width: 70px"
                                    />
                                </div>
                                <h4>Hello! let's get started</h4>
                                <h6 class="font-weight-dark">
                                    Sign in to continue.
                                </h6>
                                <h4 class="error">{{ error }}</h4>
                                <form class="pt-3">
                                    <div class="form-group">
                                        <input
                                            type="email"
                                            v-model="form.email"
                                            class="form-control form-control-lg"
                                            id="exampleInputEmail1"
                                            placeholder="Email"
                                        />
                                    </div>
                                    <div class="form-group">
                                        <input
                                            type="password"
                                            v-model="form.password"
                                            class="form-control form-control-lg"
                                            id="exampleInputPassword1"
                                            placeholder="Password"
                                        />
                                    </div>
                                    <div class="mt-3">
                                        <button
                                            class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn"
                                            @click.prevent="login()"
                                        >
                                            SIGN IN
                                        </button>
                                    </div>
                                    <div
                                        class="my-2 d-flex justify-content-between align-items-center"
                                    >
                                        <div class="form-check"></div>
                                        <a
                                            href="#"
                                            @click.prevent="
                                                $router.push({
                                                    name: 'forgot-password',
                                                })
                                            "
                                            class="auth-link text-black"
                                            >Forgot password?</a
                                        >
                                    </div>

                                    <div
                                        class="text-center mt-4 font-weight-dark"
                                    >
                                        Don't have an account?
                                        <a
                                            @click.prevent="
                                                $router.push({
                                                    name: 'register',
                                                })
                                            "
                                            href=""
                                            class="text-primary"
                                            >Register</a
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
export default {
    mounted() {
        if (this.$route.query.action) {
            if (this.$route.query.action === "new") {
                this.error =
                    "Kindly click on the link sent to your email to verify your email";
            }
        }
    },
    data() {
        return {
            form: {
                email: "",
                password: "",
            },
            error: "",
        };
    },
    methods: {
        login() {
            this.showLoader();
            this.error = "";
            this.makeRequest("POST", this.endpoints.login, {}, this.form)
                .then((response) => {
                    this.$store.commit("loginSuccess", response.data.data);
                    window.location = "/home";
                })
                .catch((error) => {
                    if (error.response) {
                        this.error = error.response.data.message;
                    } else {
                        this.error = error;
                    }
                })
                .finally(() => {
                    this.hideLoader();
                });
        },
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
.brand-logo {
    display: flex;
    justify-content: center;
}
.form-group > input {
    border-radius: 8px !important;
}

.error {
    color: #ff0000;
    text-align: center;
}
</style>
