<template>
  <main>
    <div class="container">
      <div class="row ">
        <section class="d-flex mb-5 justify-content-between">
                <div class="col-lg-8 col-md-6 col-sm-4 mb-5">
                    <h1>Цветочный бутик “Элен”</h1>
                    <p class="text-p">Создадим авторский букет с особым смыслом, чтобы вы поразили своих близких.</p>
                    <form action="" class="calltoact">
                        <button class="btn">Перейти в каталог</button>
                    </form>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-2">
                    <img class="f-site" src="../assets/images/siteFace.webp" alt="Лицо сайта">
                </div>
        </section>
        <section class="d-flex mb-5 justify-content-between">
            <div class="col-lg-8 col-md-6 col-sm-4">
              <img class="about" src="../assets/images/siteFace2.webp" alt="Лицо сайта">
            </div>
            <div class="col-lg-4 col-md-4 col-sm-2 mb-5">
              <h2>О нас</h2>
              <p class="text-p">
                  Наша история началась в 2019 году. Мы хотели построить свое дело на том чтобы дать людям возможность получать цветы исключительного качества, достойный сервис, качественную флористику за разумные деньги.
                  <br>
                  <br>
                  Мы закупаем качественные сорта цветов напрямую с сертефицированных плантаций Голандии Эквадора и России. Это позволяет гаррантировать нам свежесть каждого букета.
                  <br>
                  <br>
                  Для наших флористов создание бкетов это искусство, и как любой творц, мы вкладываем в наше дело душу.
                  <br>
                  <br>
                  Обращаясь к нам вы можете быть уверены в том, что сможете порадовать своих блиских чедесным настроением и теплом.
              </p>
            </div>
        </section>
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
    export default {
    name: 'HomeView',
    components: {
    Callback,
    Advantages,
    Catalog,
    
}
  }
</script>

<style>
    .f-site {
        width: 100%;
        height: 100%;
        border-radius: 40px;
    }

    .about {
        width: 70%;
        transform: scale(-1, 1);
        margin-top: 10px;
        height: 100%;
    }
</style>