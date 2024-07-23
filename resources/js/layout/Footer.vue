<template>
    <footer class="footer">
        <div>
            <font-awesome-icon
                icon="fa-brands fa-twitter"
                class="custom-icon"
            />
            <font-awesome-icon
                icon="fa-brands fa-facebook "
                class="custom-icon"
            />
            <font-awesome-icon
                icon="fa-brands fa-youtube"
                class="custom-icon"
            />
            <font-awesome-icon
                icon="fa-brands fa-instagram"
                class="custom-icon"
            />
        </div>
        <p>
            &copy; Copyright
            <span>{{ currentYear }}</span> ECWA MEGA CHAPEL GBAGADA
        </p>
    </footer>
</template>

<script lang="ts">
export default {
    data() {
        return {
            currentYear: new Date().getFullYear(),
        };
    },
};
</script>
<style scoped>
.footer {
    display: flex;
    justify-content: center;
    flex-direction: column;
    align-items: center;
}
.custom-icon {
    color: #00acee;
    font-size: 30px;
    margin-left: 12px;
}
.custom-icon:nth-child(2) {
    color: #3b5998;
}
.custom-icon:nth-child(3) {
    color: #c4302b;
}
.custom-icon:nth-child(4) {
    color: #d62976;
}
.custom-icon:hover {
    opacity: 0.5;
}
.footer > div {
    margin-bottom: 10px;
}
@media screen and (max-width: 900px) {
    .custom-icon {
        font-size: 20px;
    }
}
</style>
