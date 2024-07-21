<template>
        <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">     
          <li :class="getClass(link)" v-for="link in renderedLinks" :key="link.name">
            <RouterLink class="nav-link" :to="{ name : link.name }">
              <i :class="link.icon + ' menu-icon'"></i>
              <span class="menu-title">{{link.title}}</span>
            </RouterLink>
          </li>
        </ul>
    </nav>
</template>

<script lang="ts">
import { sideBarRoutes } from './routes'
export default {
    data() {
        return {
        }
    },
    methods:{
      getClass(link) {
        let current = this.$route.name;
        if (current === link.name) {
          return `nav-item active`;
        }
        return 'nav-item';
      },
      getRole(role){
        return this.user.roles.find(item => item.name === role);
      }
    },
    computed: {
      renderedLinks() {
        return sideBarRoutes()
      },
      user() {
        return this.$store.state.currentUser;
      },
    }
}
</script>
