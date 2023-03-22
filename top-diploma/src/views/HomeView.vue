<template>
  <main>
    <div class="container">
      <div class="row ">
        <Shop />
        <Actual />
        <About />
        <Catalog />
        <Advantages />
        <Callback />
          </div>
      </div>
  </main>
</template>

<script>
    import Callback from '../components/layouts/Callback.vue';
    import Advantages from '../components/layouts/Advantages.vue';
    import Catalog from '../components/layouts/Catalog.vue'; 
    import About from '../components/layouts/About.vue';
    import Shop from '../components/layouts/Shop.vue';
    import Actual from '../components/layouts/Actual.vue';

    export default {
    name: 'HomeView',
    components: {
    Callback,
    Advantages,
    Catalog,
    About,
    Shop,
    Actual  
    }
  }
</script>

<style>
    .f-site {
        width: 100%;
        height: 100%;
        border-radius: 40px;
    }
</style>