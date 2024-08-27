<template>
    <div>
        <h2>Follow Up Committee</h2>
        <div class="grid-container">
            <div
                class="grid-item"
                v-for="(contact, index) in allUsers"
                :key="index"
            >
                <label>
                    <input
                        type="checkbox"
                        v-model="selectedContacts"
                        :value="contact"
                    />
                    <p>{{ contact.name }}</p>
                </label>
            </div>
        </div>
        <div class="mt-3 boutton-submit">
            <button
                @click="submitAttendance"
                :disabled="selectedContacts.length === 0"
                class="btn btn-info btn-lg font-weight-medium auth-form-btn"
            >
                Save Committee
            </button>
        </div>
    </div>
</template>

<script>
import { mapState } from "vuex";
export default {
    data() {
        return {
            selectedContacts: [],
            users:[]
        };
    },
    created() {
        this.makeRequest('GET', this.endpoints.recipients).then(response => {
            this.selectedContacts = response.data.data;
        })
    },
    mounted()
    {
        this.$store.dispatch("fetchContactData");
    },
    computed: {
        ...mapState(["contactData"]),
        allUsers() {
            this.users = [];
            this.contactData.forEach(contact => {
                this.users.push({user_id:contact.id, name:contact.name})
            })

            return this.users;
        }
    },
    methods: {
        submitAttendance() {
            let record = [];
            this.selectedContacts.forEach((contact) => {
                record.push(contact.user_id);
            });

            this.errors = {};
            this.showLoader();
            this.makeRequest(
                "POST",
                this.endpoints.recipients,
                {},
                { users: record }
            )
                .then((response) => {
                    this.sweetAlert().success('Recipients added successfully');
                })
                .catch((error) => {
                    console.log(error.response)
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
                }).finally(() => {
                    this.hideLoader();
                });
        },
    },
};
</script>

<style>
.boutton-submit{
    text-align: center;
}
.grid-container {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 10px;
}

.grid-item {
    padding: 10px;
    border: 1px solid #ccc;
}

button {
    margin-top: 10px;
    cursor: pointer;
}
label {
    display: flex;
    align-items: center;
}
label > p {
    color: #fff;
    margin-left: 10px;
    align-self: center;
}
input {
    align-self: center;
}
</style>
