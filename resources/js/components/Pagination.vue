<template>
    <nav aria-label="...">
        <ul class="pagination">
            <li
                :class="
                    'page-item ' +
                    `${link.active ? 'active' : ''} ${
                        link.url ? '' : 'disabled'
                    }`
                "
                v-for="(link, i) in links"
                :key="i"
                @click="sendPage(link)"
            >
                <span class="page-link">
                    <span v-html="link.label"></span>
                    <span class="sr-only">(current)</span>
                </span>
            </li>
            <li class="page-itm">
                <span class="info" v-if="from"
                    >Showing {{ from }} to {{ to }} of {{ total }}</span
                >
            </li>
        </ul>
    </nav>
</template>

<script lang="ts">
export default {
    props: ["links", "from", "to", "total"],
    methods: {
        sendPage(link) {
            if (link.url) {
                let pageArray = link.url.split("page=");
                let pageFragment = pageArray[1].split("&");
                let page = pageFragment[0];
                this.$emit("page-clicked", page);
            }
        },
    },
};
</script>
<style scoped>
.info {
    color: rgb(48, 47, 47);
    padding-left: 15px;
}
.pagination {
    display: flex;
    justify-content: center;
    margin-top: 20px;
}
</style>
