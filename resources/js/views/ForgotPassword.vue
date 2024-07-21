<template>
    <div class="login">
        <div class="container-scroller">
            <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="content-wrapper d-flex align-items-center auth px-0">
                <div class="row w-100 mx-0">
                <div class="col-lg-4 mx-auto">
                    <div class="auth-form-light text-left py-5 px-4 px-sm-5">
                    <div class="brand-logo">
                        <img src="../assets/images/ecwalogo.jpg" alt="logo" style="width:70px;">
                    </div>
                    <h4>Hello! sorry that you forgot you password</h4>
                    <h4 class="error">{{error}}</h4>
                    <form class="pt-3">
                        <div class="form-group">
                        <input type="email" v-model="form.email" class="form-control form-control-lg" id="exampleInputEmail1" placeholder="Email">
                        </div>
                        <div class="mt-3">
                        <button class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn" @click.prevent="login()">Send Reset Link</button>
                        </div>
                      
                        <div class="form-check">
                            
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
           
        },
        data() {
            return {
                form:{
                    email:''
                },
                error:''
            }
        },
        methods:{
            login() {
                this.showLoader();
                this.error = '';
                this.makeRequest('POST', this.endpoints.sendResetLink, {}, this.form)
                .then(response => {
                    this.sweetAlert().success(response.data.message);
                }).catch(error => {
                    console.log(error.response);
                    if (error.response) {
                        this.error = error.response.data.message;
                    }
                    else{
                        this.error = error
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