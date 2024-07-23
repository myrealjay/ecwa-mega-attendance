<template>
    <div class="login">
        <div class="container-scroller">
            <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="content-wrapper d-flex align-items-center auth px-0">
                <div class="row w-100 mx-0">
                <div class="col-lg-4 mx-auto">
                    <div class="auth-form-light text-left py-5 px-4 px-sm-5">
                    <div class="brand-logo">
                        <img src="../assets/images/megalogo.jpg" alt="logo" style="width:70px;">
                    </div>
                    <h4>Hello! Reset your password</h4>
                    <h4 class="error">{{ errors.token ? errors.token[0] : '' }}</h4>
                    
                    <form class="pt-3">
                        <EmailField label="Email" v-model="form.email" :error="errors.email? errors.email[0] : ''" />

                        <PasswordField label="Password" v-model="form.password" 
                        :error="errors.password ? errors.password[0] : ''" />

                        <PasswordField label="Confirm Password" v-model="form.password_confirmation" 
                        :error="errors.password ? errors.password[0] : ''" />

                        <div class="mt-3">
                        <button class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn" 
                        @click.prevent="login()">Reset Password</button>
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
import PasswordField from "../components/PasswordField.vue";

    export default {
        components: { TextField, EmailField, PasswordField },
        mounted() {
          
        },
        data() {
            return {
                form:{
                    email:'',
                    password:'',
                    password_confirmation:''
                },
                errors:{}
            }
        },
        methods:{
            login() {
                this.errors = {};
                this.form.token = this.$route.params.token;
                this.showLoader();
                this.makeRequest('POST', this.endpoints.resetPassword, {}, this.form)
                .then(response => {
                    this.sweetAlert().success(response.data.message);
                    this.$router.push({name:'login'});
                }).catch(error => {
                    console.log(error.response);
                    if (error.response) {
                        if (!error.response.data.data) {
                            this.sweetAlert().error(error.response.data.message);
                        }
                        else {
                            this.errors = error.response.data.data;
                        }
                    }
                }).finally(() => {
                    this.hideLoader();
                })
            }
        }
    }
</script>
<style scoped>
    .container-fluid{
        background: url(../assets/images/ecwa.png);
        background-repeat: no-repeat;
        background-size: cover;
        background-position: center;
    }
    .content-wrapper{
        background-color: rgba(0, 0, 0,0.7);
    }
    .font-weight-dark{
        color:rgb(111, 108, 108);
    }
    .error{
        color:#ff0000;
        text-align: center;
    }
</style>