<template>
    <section>
        <div class="col-lg-12 col-md-8 col-sm-4 mb-5">
            <h2 class="h-text mb-5">Отзывы клиентов о нас</h2>
                <swiper ref="mySwiper" :options="swiperOptions" class="swiper" :modules="modules" :slides-per-view="1" :space-between="30" :loop="true" :navigation="true">
                        <swiper-slide v-for="(review, index) in this.review" :key="index">
                        <img :src="review.image" class="d-block w-25 slide_image">
                        </swiper-slide>
                </swiper>
        </div>
    </section>    
</template>
  
<script>
    import { getAllReviews } from '../services/ApiMethods';
    import { baseUrlStorage } from '../services/config.js';
    import { Navigation } from 'swiper'
    import { Swiper, SwiperSlide } from 'swiper/vue'

    export default {
    name: 'Reviews',
    components: {
        Swiper,
        SwiperSlide
    },
    data(){
        return {
            review: [],
            modules: [Navigation]
        }
      },
      async created(){
        this.review = await this.getAllReviews();
      },
      methods:{
        async getAllReviews() {
          try {
          let review = await getAllReviews();
            review = review.data.reviews.map((item, index) => {
                return {
                    id: item.id,
                    image: baseUrlStorage + item.image,
                    active: true,
                }
            });
            console.log(review);    
            return review;
            
          } catch (error) {
              alert("Отзывы не найдены!", "error");
            }   
        },
      }
  }
</script>

<style>
    .slide_image {
        margin: 0 auto;
        height: 95vh;
    }
</style>