<template>
    <div>
        <h1>{{ contact.name }}</h1>
        <p><strong>Phone Number:</strong> {{ contact.phone_number }}</p>
        <p><strong>Email:</strong> {{ contact.email }}</p>
        <p><strong>Address:</strong> {{ contact.address }}</p>
        <p><strong>Date of Birth:</strong> {{ formatDate(contact.dob, true) }}</p>
        <p><strong>Occupation</strong> {{ contact.occupation }}</p>
        <p><strong>Wedding Date</strong> {{ contact.wedding_date?formatDate(contact.wedding_date, true) :'' }}</p>

        <div class="picture">
            <img v-if="contact.picture" :src="contact.picture" width="400" />
        </div>
       
    </div>
</template>

<script>
export default {
    props: ["id"],
    data() {
        return {
            contact: {},
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

                    console.log(response.data.data);
                    console.log(contact.picture);
                })
                .catch((error) => {
                    console.log(error.response);
                });
        },
    },
};
</script>
<style>
.picture {
    padding:15px;
    padding-top:25px;
}
</style>
