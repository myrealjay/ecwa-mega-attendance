import { createStore } from "vuex";
import moment from "moment";
import { endpoints } from "./helpers/endpoints";
import { makeRequest } from "./helpers/requester";
import { fetchLogedInUser } from "./helpers/userFetcher";

// Create a new store instance.
const store = createStore({
    state() {
        return {
            currentUser: fetchLogedInUser(),
            contactData: [],
        };
    },
    mutations: {
        loginSuccess(state, payload) {
            state.currentUser = payload;
            const userString = JSON.stringify(state.currentUser);
            sessionStorage.setItem("user", userString);
        },
        logout(state) {
            sessionStorage.removeItem("user");
            window.location = "/";
        },
        fetchQuizCategory(state, payload) {
            state.currentUser.categories = payload;
            const userString = JSON.stringify(state.currentUser);
            sessionStorage.setItem("user", userString);
        },
        setContactData(state, payload) {
            state.contactData = payload;
            const contacts = JSON.stringify(state.contactData);
            sessionStorage.setItem("contactData", contacts);
            console.log(contacts);
        },
    },
    getters: {
        isLogedIn(state) {
            if (!state.currentUser) {
                return false;
            }
            return true;
        },
        shouldRefresh(state) {
            if (!state.currentUser) {
                return false;
            }
            let expiryTime = moment(state.currentUser.expiry).subtract(
                4,
                "minute"
            );
            if (moment().isAfter(expiryTime)) {
                return true;
            }
            return false;
        },
        contactData: (state) => state.contactData,
    },
    actions: {
        async refreshToken(context) {
            makeRequest("POST", endpoints().refreshToken)
                .then((response) => {
                    context.commit("loginSuccess", response.data.data);
                })
                .catch((error) => {
                    if (error.response) {
                        if (error.response.status === 401) {
                            context.commit("logout");
                        }
                    }
                });
        },
        fetchCategory(context) {
            return new Promise((resolve, reject) => {
                makeRequest("GET", endpoints().fetchUserWallets)
                    .then((response) => {
                        context.commit("fetchQuizCategory", response.data.data);
                        resolve("");
                    })
                    .catch((error) => {});
            });
        },
        fetchContactData(context) {
            return new Promise((resolve, reject) => {
                makeRequest("GET", endpoints().fetchAllUsers)
                    .then((response) => {
                        context.commit("setContactData", response.data.data);

                        resolve("");
                    })
                    .catch((error) => {});
            });
        },
    },
});

export function appStore() {
    return store;
}
