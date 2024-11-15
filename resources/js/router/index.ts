import { createRouter, createWebHistory } from "vue-router";
import Home from "../views/Home.vue";
import Login from "../views/Login.vue";
import { homeChildren } from "./homeChildren";
import NotFound from "../views/NotFound.vue";
import { appStore } from "../store";
import { sideBarRoutes } from "@/layout/routes";
import { otherRoutes } from "@/layout/otherRoutes";
import ForgotPassword from "../views/ForgotPassword.vue";
import ResetPassword from "../views/ResetPassword.vue";
import Landing from '../views/Landing.vue';

const store = appStore();

const router = createRouter({
    history: createWebHistory('/build/'),
    routes: [
        {
            path: "/",
            name: "landing",
            component: Landing
        },
        {
            path: "/login",
            name: "login",
            component: Login,
            beforeEnter: async (to, from, next) => {
                const isLogedIn = store.state.currentUser;
                if (isLogedIn) {
                    next("/home");
                } else {
                    next();
                }
            },
        },
        {
            path: "/forgot-password",
            name: "forgot-password",
            component: ForgotPassword,
            beforeEnter: async (to, from, next) => {
                const isLogedIn = store.state.currentUser;
                if (isLogedIn) {
                    next("/home");
                } else {
                    next();
                }
            },
        },
        {
            path: "/auth/change-password/:token",
            name: "reset-password",
            component: ResetPassword,
            beforeEnter: async (to, from, next) => {
                const isLogedIn = store.state.currentUser;
                if (isLogedIn) {
                    next("/home");
                } else {
                    next();
                }
            },
        },
        {
            //This is where secured routes will go into
            path: "/home",
            component: Home,
            beforeEnter: async (to, from, next) => {
                if (store.getters.shouldRefresh) {
                    await store.dispatch("refreshToken");
                }

                const isLogedIn = store.state.currentUser;

                if (!isLogedIn) {
                    store.commit("logout");
                    next("/");
                } else {
                    const sideRoute = sideBarRoutes().find(
                        (item) => item.name === to.name
                    );
                    const otherRoute = otherRoutes().find(
                        (item) => item.name === to.name
                    );
                    if (!sideRoute && !otherRoute) {
                        next(from.path);
                    }

                    next();
                }
            },
            children: [...homeChildren()],
        },
        {
            path: "/:pathMatch(.*)*",
            name: "404",
            component: NotFound,
        },
    ],
});

export default router;
