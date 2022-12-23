<template>

  <Sidebar v-if="!isLogin && !isNotFound" >
      <router-view />
  </Sidebar>
  <router-view v-else />
 
</template>
<script setup>
   
      import { computed } from 'vue';
      import {  useRoute } from 'vue-router'
      import Sidebar from './layouts/Sidebar.vue'
      const routes = useRoute();

      
      const isLogin = computed(() => {
        return routes.name === 'login'
      });

      const isNotFound = computed(() => {
        return routes.name === 'not-found'
      });
         
</script>
   