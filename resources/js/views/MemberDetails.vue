<template>
    <div class="profile-container">
        <div class="profile-header">
            <h1>{{ contact.name }}</h1>
            <div class="profile-header-left">
                <img src="../assets/images/faces/face28.jpg" alt="profile" />
                <p>{{ contact.occupation }}</p>
                <P>{{ contact.phone_number }}</P>
            </div>
        </div>
        <div class="profile-details">
            <p><strong>Phone Number:</strong> {{ contact.phone_number }}</p>
            <p><strong>Email:</strong> {{ contact.email }}</p>
            <p><strong>Address:</strong> {{ contact.address }}</p>
            <p><strong>Date of Birth:</strong> {{ contact.dob }}</p>
            <p><strong>Occupation:</strong> {{ contact.occupation }}</p>
            <p><strong>Wedding Date:</strong> {{ contact.wedding_date }}</p>
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
                })
                .catch((error) => {
                    console.log(error.response);
                });
        },
    },
};
</script>

<style scoped>
.profile-container {
    background: #fff;
    border-radius: 8px;
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
}

.profile-picture img {
    max-width: 150px;
    border-radius: 50%;
    object-fit: cover;
}
</style>
