<script setup>
import { RouterLink, RouterView } from 'vue-router';
import  Header  from './components/layouts/Header.vue';
import Footer from './components/layouts/Footer.vue';
</script>

<template>
  <Header />
  
  <RouterView />

  <Footer />
</template>

<style>

</style>
