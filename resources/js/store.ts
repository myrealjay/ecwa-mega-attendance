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
            attendantData: {}, // Updated to be an object to store date-based data
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
        },
        setAttendantData(state, payload) {
            console.log("Received attendant data:", payload);

            state.attendantData = payload;
            const attendants = JSON.stringify(state.attendantData);
            sessionStorage.setItem("attendantData", attendants);
            console.log("Updated state.attendantData:", state.attendantData);
        },
    },
    getters: {
        isLogedIn(state) {
            return !!state.currentUser;
        },
        shouldRefresh(state) {
            if (!state.currentUser) return false;
            let expiryTime = moment(state.currentUser.expiry).subtract(
                4,
                "minute"
            );
            return moment().isAfter(expiryTime);
        },
        contactData: (state) => state.contactData,
        attendantData: (state) => state.attendantData,
    },
    actions: {
        async refreshToken(context) {
            makeRequest("POST", endpoints().refreshToken)
                .then((response) => {
                    context.commit("loginSuccess", response.data.data);
                })
                .catch((error) => {
                    if (error.response && error.response.status === 401) {
                        context.commit("logout");
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
                    .catch((error) => {
                        reject(error);
                    });
            });
        },
        fetchContactData(context) {
            return new Promise((resolve, reject) => {
                makeRequest("GET", endpoints().fetchAllUsers)
                    .then((response) => {
                        context.commit("setContactData", response.data.data);
                        resolve("");
                    })
                    .catch((error) => {
                        reject(error);
                    });
            });
        },
        fetchAttendantData({ commit }, { date }) {
            return new Promise((resolve, reject) => {
                const url = `${endpoints().fetchAttendanceByDate}?date=${date}`;
                makeRequest("GET", url)
                    .then((response) => {
                        console.log("API response:", response);
                        if (response && response.data) {
                            commit("setAttendantData", response.data.data);
                        } else {
                            console.error(
                                "Unexpected response format:",
                                response
                            );
                        }
                        resolve("");
                    })
                    .catch((error) => {
                        console.error("Error fetching attendance data:", error);
                        reject(error);
                    });
            });
        },
    },
});

export function appStore() {
    return store;
}
