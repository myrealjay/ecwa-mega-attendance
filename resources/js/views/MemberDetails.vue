<template>
    <div class="profile-container">
        <div class="profile-header">
            <h1>{{ contact.name }}</h1>
            <div class="profile-header-left">
                <img v-if="contact.picture" :src="contact.picture" alt="profile"  width="80"/>
                <img v-else="!contact.picture" src="../assets/images/faces/face28.jpg" alt="profile" />
                <p>{{ contact.occupation }}</p>
                <P>{{ contact.phone_number }}</P>
            </div>
        </div>
        <div class="profile-details">
            <TextField label="Phone Number" v-model="contact.phone_number" 
            :error="errors.phone_number ? errors.phone_number[0] : ''"/>

            <TextField label="Email" v-model="contact.email" :error="errors.email ? errors.email[0] : ''"/>
            <TextField label="Address" v-model="contact.address" :error="errors.address ? errors.address[0] : ''"/>

            <DateTimeField label="DOB" v-model="contact.dob" :error="errors.dob ? errors.dob[0] : ''"/>
            <DateTimeField label="Wedding Date" v-model="contact.wedding_date" 
            :error="errors.wedding_date ? errors.wedding_date[0] : ''"/>

            <SingleSelect
                :options="gender"
                label="Gender"
                custom_value="name"
                v-model="contact.gender"
                text="name"
            ></SingleSelect>

            <div class="picture">
                <img v-if="contact.picture" :src="contact.picture" width="400" />
            </div>

            <Button
                    icon="mdi-send"
                    text="Register"
                    color="primary"
                    @buttonClicked="updateUser()"
                />
        </div>
    </div>
</template>

<script>
import TextField from "../components/TextField.vue";
import DateTimeField from "../components/DateTimeField.vue";
import Button from "../components/Button.vue";
import SingleSelect from "../components/SingleSelect.vue";

export default {
    components:{TextField, DateTimeField, Button, SingleSelect},
    props: ["id"],
    data() {
        return {
            contact: {},
            errors: {},
            gender:[
                {name: 'Male'},
                {name: 'Female'}
            ],
        };
    },
    created() {
        this.fetchContactDetails();
    },
    methods: {
        async fetchContactDetails() {
            const url = `/users/${this.id}`;
            await this.makeRequest("GET", url)
                .then((response) => {
                    this.contact = response.data.data;
                })
                .catch((error) => {
                    console.log(error.response);
                });
        },

        updateUser() {
            this.errors = {};
            this.showLoader();
            this.makeRequest("PUT", this.endpoints.updateUser+'/'+this.contact.id, {}, this.contact)
                .then((response) => {
                    this.sweetAlert().success("Member Updated successfully");
                })
                .catch((error) => {
                    console.log(error.response.data);
                    if (error.response) {
                        this.errors = error.response.data.data
                    }

                    this.sweetAlert().error("Error Updated User");
                })
                .finally(() => {
                    this.hideLoader();
                });
        }
    },
};
</script>

<style scoped>
.picture {
    padding:15px;
    padding-top:25px;
}
.profile-container {
    background: #fff;
    border-radius: 8px;
    padding:15px;
    overflow: auto;
}
.profile-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin: 20px;
}
.profile-header-right {
    display: flex;
    flex-direction: row;
    justify-content: center;
    align-items: center;
}
.profile-details {
    flex: 1;
    padding-right: 20px;
    padding-left: 20px;
}

.profile-picture img {
    max-width: 150px;
    border-radius: 50%;
    object-fit: cover;
}
</style>
