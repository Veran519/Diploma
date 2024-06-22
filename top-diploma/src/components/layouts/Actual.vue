<!-- Блок информации, в котором содержится слайдер с акутальными товарами на текущий момент или доступными, или доступными, но теми, которые есть возможность повторить -->
<template>
    <section class=" mt-5 slider">
        <h2 class="mb-5 actual_heading">Актуально сейчас!</h2>
        <swiper ref="mySwiper" :options="swiperOptions" class="swiper" :modules="modules"  :loop="true" :autoplay="{delay: 2500, disableOnInteraction: false}" :breakpoints="{slidesPerView:3, 640: {slidesPerView:3, spaceBetween: 30}, 480: {slidesPerView:2, spaceBetween: 20}, 320: {slidesPerView:1, spaceBetween: 10}}">
            <swiper-slide v-for="(items, index) in this.actual" :key="index">
                <div class ="box">
                    <a :href="items.picture" data-lightbox="items.picture" data-title="My caption"><img :src="items.picture" class="img_slide"></a>
                    <div class="ribbon-right" v-if="items.isActual">Актуально сейчас!</div>
                    <div class="flag-right" v-if="items.isAvailable">Можем повторить!</div>
                </div>
            </swiper-slide>
        </swiper>
    </section>    
</template>
  
<script>
    import { Swiper, SwiperSlide } from 'swiper/vue'    // Импортируем слайдер Swiper со всеми его настройками и ключами, далее получаем const префикс для изображений с бд, а также получаем метод, который получает интересующие нас изображения
    import { baseUrlStorage } from "../../services/config.js";
    import {  Autoplay } from 'swiper'
    import { getActualProducts } from '../../services/ApiMethods';
    import { toast } from 'vue3-toastify';

    export default {
    name: 'Reviews',
    components: {
        Swiper,     // Указываем компоненты слайдера
        SwiperSlide
    },
    data(){
        return {
            modules: [Autoplay],    // Подключаем модуль автопроигрыша для слайдера
            actual: []  // пустой массив актуальных изображений букетов, который будет наполняться
        }
      },
      async created(){
        this.actual = await this.getActualProducts();   // Приравниваем пустой массив актуальности к функции, которая его заполняет
      },
      methods:{
        async getActualProducts() { // Метод получения данных с сервера для заполнения массива актуальности
          try {
          let actual = await getActualProducts();   // Объявляем переменную actual и приравниваем ее к функции получения актуальных букетов с сервера
            actual = actual.data.product.map((item, index) => { // Производим перебор массива посредством map и возвращаем интересущие нас данные
                if(item.isActual = 1) { // Если Актуально, используем след код
                    return {
                        picture: baseUrlStorage + item.picture,
                        isActual: item.isActual,
                        isAvailable: item.isAvailable
                    };
                }
                if(item.isAvailable = 1) {  // Если доступно, выводим код ниже
                    return {
                        picture: baseUrlStorage + item.picture,
                        isActual: item.isActual,
                        isAvailable: item.isAvailable
                    };
                }
                });
                  
            return actual;  // Возвращаем актуальные букеты
          } catch (error) {
                toast.error("Ни одного букета не было найдено, который удовлетворял бы условиям"); 
            }   
        },
      }
  }
</script>

<style>
    .img_slide {
        width: 400px;
        height: 500px;
        border-radius: 10px;
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
    @media screen and (max-width: 1624.98px) 
    {
        .img_slide {
            width: 310px;
            height: 450px;
        }
        .slider {
            width: 100%;
        }
    }
    @media screen and (max-width: 1050.98px) 
    {
        .img_slide {
            width: 277px;
            height: 400px;
        }  
    }
    @media screen and (max-width: 992.98px) 
    {
        .img_slide {
            width: 258px;
        }  
    }
    @media screen and (max-width: 895.98px) 
    {
        .img_slide {
            width: 95.9%;
        }
    }
    @media screen and (max-width: 806.98px) 
    {
        .img_slide {
            width: 95.1%;
            height: 300px;
        }
    }
    @media screen and (max-width: 739.98px) 
    {
        .img_slide {
            width: 94.6%;
        }
    }
    @media screen and (max-width: 670.98px) 
    {
        .img_slide {
            width: 94.1%;
            height: 250px;
        }
    }
    @media screen and (max-width: 639.98px) 
    {
        .img_slide {
            width: 96%;
            height: 400px;
        }
    }
    @media screen and (max-width: 557.98px) 
    {
        .img_slide {
            width: 95.5%;
            height: 350px;
        }
    }
    @media screen and (max-width: 501.98px) 
    {
        .img_slide {
            width: 95%;
        }
    }
    @media screen and (max-width: 480.98px) 
    {
        .img_slide {
            height: 270px;
        }
    }
    @media screen and (max-width: 479.98px) 
    {
        .img_slide {
            width: 97.5%;
            height: 600px;
        }
    }
    @media screen and (max-width: 405.98px) 
    {
        .img_slide {
            width: 97%;
            height: 500px;
        }
    }
    @media screen and (max-width: 360.98px) 
    {
        .img_slide {
            width: 96.5%;
        }
    }
</style>