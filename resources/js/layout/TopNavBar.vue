<template>
    <div>
        <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
            <div
                class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center"
            >
                <a class="navbar-brand brand-logo mr-5" href="/home"
                    ><img
                        src="../assets/images/megalogo.jpg"
                        class="mr-2"
                        alt="logo"
                /></a>
                <a class="navbar-brand brand-logo-mini" href="/home"
                    ><img src="../assets/images/megalogo.jpg" alt="logo"
                /></a>
            </div>
            <div
                class="navbar-menu-wrapper d-flex align-items-center justify-content-end"
            >
                <button
                    class="navbar-toggler navbar-toggler align-self-center"
                    type="button"
                    data-toggle="minimize"
                >
                    <span class="icon-menu"></span>
                </button>
                <ul class="navbar-nav mr-lg-2">
                    <li class="nav-item nav-search d-none d-lg-block">
                        <div class="input-group">
                            <div
                                class="input-group-prepend hover-cursor"
                                id="navbar-search-icon"
                            >
                                <!-- <span class="input-group-text" id="search">
                  <i class="icon-search"></i>
                </span> -->
                            </div>
                            <!-- <input type="text" class="form-control" id="navbar-search-input" placeholder="Search now" aria-label="search" aria-describedby="search"> -->
                        </div>
                    </li>
                </ul>
                <ul class="navbar-nav navbar-nav-right">
                    <li class="nav-item nav-profile dropdown">
                        <a
                            class="nav-link dropdown-toggle"
                            href="#"
                            data-toggle="dropdown"
                            id="profileDropdown"
                        >
                            <img
                                v-if="currentUser.picture"
                                :src="currentUser.picture"
                                alt="profile"
                            />
                            <img
                                v-else
                                src="../assets/images/faces/face28.jpg"
                                alt="profile"
                            />
                        </a>
                        <div
                            class="dropdown-menu dropdown-menu-right navbar-dropdown"
                            aria-labelledby="profileDropdown"
                        >
                            <a class="dropdown-item" @click.prevent="logout()">
                                <i class="ti-power-off text-primary"></i>
                                Logout
                            </a>
                            <a
                                class="dropdown-item"
                                @click.prevent="changePassword()"
                            >
                                <i class="ti-key text-primary"></i>
                                Change Password
                            </a>
                        </div>
                    </li>
                </ul>
                <button
                    class="navbar-toggler navbar-toggler-right d-lg-none align-self-center"
                    type="button"
                    data-toggle="offcanvas"
                >
                    <span class="icon-menu"></span>
                </button>
            </div>
        </nav>

        <Modal
            id="changePasswordModal"
            title="Change Password"
            :open="changePasswordModalOpen"
            @closed="changePasswordModalOpen = false"
            :large="false"
        >
            <div>
                <div class="line"></div>
                <form class="pt-3">
                    <PasswordField
                        label="Old Password"
                        v-model="form.old_password"
                        :error="
                            errors.old_password ? errors.old_password[0] : ''
                        "
                    />
                    <PasswordField
                        label="New Password"
                        v-model="form.password"
                        :error="errors.password ? errors.password[0] : ''"
                    />
                </form>
            </div>
            <template #buttons>
                <Button
                    icon="mdi-send"
                    text="Submit"
                    color="primary"
                    @buttonClicked="submitPasswordChange()"
                />
            </template>
        </Modal>
    </div>
</template>

<script lang="ts">
import { endpoints } from "../helpers/endpoints";
import Modal from "../components/Modal.vue";
import PasswordField from "../components/PasswordField.vue"
import Button from "../components/Button.vue";

export default {
    components:{Modal, PasswordField, Button},
    data() {
        return {
            changePasswordModalOpen: false,
            form: {
                password: "",
                old_password: "",
            },
            errors: {},
        };
    },
    methods: {
        logout() {
            this.showLoader();
            this.makeRequest("POST", endpoints().logout)
                .then((response) => {
                    this.$store.commit("logout");
                })
                .catch((error) => {
                    this.$store.commit("logout");
                })
                .finally(() => {
                    this.hideLoader();
                });
        },

        changePassword() {
            this.changePasswordModalOpen = true;
        },
        submitPasswordChange() {
            this.errors = {};
            this.showLoader();
            this.makeRequest("POST", this.endpoints.changePassword, {}, this.form)
                .then((response) => {
                    this.sweetAlert().success("Member Added successfully");
                    this.changePasswordModalOpen = false;
                    this.form = {
                        password: "",
                        old_password: "",
                    };

                    this.logout();
                })
                .catch((error) => {
                    this.sweetAlert().error("Error Changing password");
                    console.log(error.response.data);
                })
                .finally(() => {
                    this.hideLoader();
                });
        },
    },
    computed: {
        currentUser() {
            return this.$store.state.currentUser;
        },
    },
};
</script>
