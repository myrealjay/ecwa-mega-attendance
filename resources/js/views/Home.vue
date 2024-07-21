<template>

<div class="container-scroller">
   <TopNavBar />

    <div class="container-fluid page-body-wrapper">
      <RightSideBar />
      <LeftSideBar />

      <div class="main-panel">
        <div class="content-wrapper">
            <RouterView />
        </div>
        <Footer />
      </div>
    </div>
    
  </div>
</template>

<script lang="ts">
import { RouterLink, RouterView } from "vue-router";
import TopNavBar from "../layout/TopNavBar.vue";
import RightSideBar from "../layout/RightSideBar.vue";
import LeftSideBar from "../layout/LeftSideBar.vue";
import Footer from "../layout/Footer.vue";
import Skins from "../layout/Skins.vue";
export default {
    components: { TopNavBar, RightSideBar, LeftSideBar, Footer, Skins },
    created() {
      this.$store.dispatch('fetchCategory').then(() => {
        
      });
    }
}
</script>

<style scoped>

</style>
