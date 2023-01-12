<template>
    <section class=" mt-5 slider">
        <h2 class="mb-5 actual_heading">Актуально сейчас!</h2>
        <swiper ref="mySwiper" :options="swiperOptions" class="swiper" :modules="modules" :slides-per-view="3" :space-between="30" :loop="true" :autoplay="{delay: 2500, disableOnInteraction: false}">
            <swiper-slide v-for="(items, index) in this.actual" :key="index">
                <div class ="box">
                    <img :src="items.picture" class="img_slide">
                    <div class="ribbon-right" v-if="items.isActual">Актуально сейчас!</div>
                    <div class="flag-right" v-if="items.isAvailable">Можем повторить!</div>
                </div>
            </swiper-slide>
        </swiper>
    </section>    
</template>
  
<script>
    import { Swiper, SwiperSlide } from 'swiper/vue'
    import { baseUrlStorage } from "../../services/config.js";
    import {  Autoplay } from 'swiper'
    import { getActualProducts } from '../../services/ApiMethods';

    export default {
    name: 'Reviews',
    components: {
        Swiper,
        SwiperSlide
    },
    data(){
        return {
            modules: [Autoplay],
            actual: []
        }
      },
      async created(){
        this.actual = await this.getActualProducts();
        console.log(this.actual)
      },
      methods:{
        async getActualProducts() {
          try {
          let actual = await getActualProducts();
            actual = actual.data.product.map((item, index) => {
                if(item.isActual = 1) {
                    return {
                        picture: baseUrlStorage + item.picture,
                        isActual: item.isActual,
                        isAvailable: item.isAvailable
                    };
                }
                if(item.isAvailable = 1) {
                    return {
                        picture: baseUrlStorage + item.picture,
                        isActual: item.isActual,
                        isAvailable: item.isAvailable
                    };
                }
                });
                  
            return actual;
          } catch (error) {
              alert("Актуальные товары не найдены!", "error");
            }   
        },
      }
  }
</script>

<style>
    .img_slide {
        width: 400px;
        height: 500px;
    }
    .slider {
        margin-bottom: 100px;
    }
    .box {
        position: relative;
        margin: 0 auto;
    }
    .ribbon-right {
        position: absolute;
        top: 18px;
        right: 2px;
        color: #fff;
        background: #32be5b;
        padding: 0 20px;
        height: 29px;
        line-height: 26px;
    }
    .ribbon-right:before {
        content: "";
        position: absolute;
        left: -9px;
        top: 0;    
        height: 0;
        width: 0;
        border-style: solid;
        border-width: 13px 11px 13px 0;
        border-color: transparent #32be5b transparent transparent;
        transform: scaleX(.65);
    }
    .ribbon-right:after {
        content: "";
        position: absolute;
        height: 0;
        width: 0;
        border-style: solid;
        border-color: #32be5b transparent transparent;
        border-width: 8px 10px 0 0;    
        top: 100%;
        right: 0;
    }
    .flag-right {
        position: absolute;
        top: 18px;
        right: 2px;
        color: #fff;
        background: #d12cc3;
        padding: 0 20px;
        height: 29px;
        line-height: 26px;
    }
    .flag-right:before {
        content: "";
        position: absolute;
        left: -9px;
        top: 0;    
        height: 0;
        width: 0;
        border-style: solid;
        border-width: 13px 11px 13px 0;
        border-color: transparent #da30b2 transparent transparent;
        transform: scaleX(.65);
    }
    .flag-right:after {
        content: "";
        position: absolute;
        height: 0;
        width: 0;
        border-style: solid;
        border-color: #da30b2 transparent transparent;
        border-width: 8px 10px 0 0;    
        top: 100%;
        right: 0;
    } 
    .actual_heading {
        text-align: center;
        font-family: 'Pacifico';
        font-size: 32px;
        line-height: 140%;
        color: #502D5C;
        margin: 0 auto;
    }
</style>