<!-- Блок с отзывами покупателей -->
<template>
    <section>
        <div class="col-lg-12 col-md-12 col-sm-12 mb-5">
            <h2 class="h-text mb-5">Отзывы клиентов о нас</h2>
                <swiper ref="mySwiper" class="swiper" :modules="modules" :slides-per-view="1" :space-between="30" :loop="true" :navigation="true">
                        <swiper-slide v-for="(review, index) in this.review" :key="index">
                        <img :src="review.image" class="d-block slide_image">
                        </swiper-slide>
                </swiper>
        </div>
    </section>    
</template>
  
<script>
    import { getAllReviews } from '../services/ApiMethods';     // Импортируем функцию получения отзывов с апи
    import { baseUrlStorage } from '../services/config.js';     // Импорт префикса для изображений
    import { Navigation } from 'swiper';    // Импортируем навигацию для слайдера
    import { Swiper, SwiperSlide } from 'swiper/vue';   // Импортируем настройки и сам слайдер
    import { toast } from 'vue3-toastify';

    export default {
    name: 'Reviews',
    components: {
        Swiper,
        SwiperSlide
    },
    data(){
        return {
            review: [],         // Возвращаем отзывы
            modules: [Navigation]       // Управляющий модуль навигации по щелчку
        }
      },
      async created(){
        this.review = await this.getAllReviews();   // Получаем все отзывы пользователей с апи
      },
      methods:{
        async getAllReviews() {     // Метод получения отзывов пользователей
          try {
          let review = await getAllReviews();   // Получаем отзывы с api
            review = review.data.reviews.map((item, index) => {     // Перебираем полученные данные, извлекая нужные
                return {
                    id: item.id,
                    image: baseUrlStorage + item.image,
                    active: true,
                }
            });
                
            return review;  // Записываем полученные данные в новый массив и возвращаем его 
            
          } catch (error) {         // При наличии ошибок выводим сообщение
              toast.error('Ни одного отзыва нет, увы :(');
            }   
        },
      }
  }
</script>

<style>
    .slide_image {
        margin: 0 auto;
        height: 95vh;
        border-radius: 8px;
    }
    @media screen and (max-width: 767.98px) 
    {
        .slide_image {
            width: 45%;
        }
    }
    @media screen and (max-width: 597.98px) 
    {
        .slide_image {
            width: 40%;
            height: 75vh;
        }
    }
    @media screen and (max-width: 499.98px) 
    {
        .slide_image {
            width: 65%;
            height: 100vh;
        }
    }
    @media screen and (max-width: 395.98px) 
    {
        .slide_image {
            width: 60%;
            height: 70vh;
        }
    }
</style>