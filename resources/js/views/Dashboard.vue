<template>
    <div>
        <div className="board_upper">
            <div>
                <h1>
                    Welcome back, {{ currentUser.first_name }}
                    <font-awesome-icon icon="fa-solid fa-hand " class="hand" />
                </h1>
                <p>
                    Take your Bible Quiz with ease, anytime,
                    <br />
                    anywhere!
                </p>
            </div>

            <div class="bible">
                <img src="../assets/images/bible.jpg" alt="logo" />
            </div>
        </div>
        <div class="button-container">
            <Button
                text="See Quiz"
                color="primary"
                icon="mdi mdi-eye"
                @buttonClicked="$router.push({ name: 'myinvitations' })"
            ></Button>
        </div>
    </div>
</template>

<script lang="ts">
import Button from "../components/Button.vue";
export default {
    components: { Button },
    mounted() {},
    data() {
        return {};
    },
    methods: {},
    computed: {
        currentUser() {
            return this.$store.state.currentUser;
        },
    },
};
</script>
<style scoped>
.board_upper {
    display: flex;
    justify-content: space-between;
    padding: 20px;
    background-color: #073883;
    color: #fff;
    border-radius: 16px;
    margin-bottom: 20px;
}
.board_upper > div > h1 {
    text-align: left;
    font-size: 50px;
    font-weight: 700;
    text-transform: capitalize;
}
.board_upper > div > p {
    color: #e7bebe;
}
.hand {
    color: gold;
}
.bible > img {
    background-color: #073883;
    width: 90%;
    height: 80%;
    border-radius: 8px;
}
@media screen and (max-width: 900px) {
    .board_upper {
        padding: 10px;
    }
    .board_upper > h1 {
        font-size: 20px;
        word-wrap: break-word;
    }
}
</style>
