<template>
    <section class="mt-5 mb-5">
              <h2 class="h-text mb-5">Каталог</h2>
              <div class="d-flex">
                  <div class="item_bouqet justify-content-between mb-5" v-for="(category, index) in this.category" :key="index">
                      <h3 class="cat-h">{{category.name}}</h3>
                      <div class="img_container">
                        <a :href="category.image_preview" data-lightbox="image-1" data-title="My caption"><img :src="category.image_preview" class="img_size mb-5" alt=""></a>
                      </div>
                      <form action="" class="calltoact buyC">
                          <div class="bt" @click="this.$router.push('/Products')">Купить</div>
                      </form>
                  </div>
              </div>
        </section>    
</template>
  
<script>
    import { getCategories } from "../../services/ApiMethods";
    import { baseUrlStorage } from "../../services/config.js";

    export default {
      name: 'Catalog',
      components: {
        
      },
      data(){
        return {
            category: [],
        }
      },
      async created(){
        this.category = await this.getCategories();
      },
      methods:{
        async getCategories() {
          try {
          let category = await getCategories();
            category = category.data.categories.map((item, index) => {
                return {
                    name: item.name,
                    id: item.id,
                    image_preview: baseUrlStorage + item.prevImage
                };
            });
                  
            return category;
          } catch (error) {
              alert("Работы не были получены!", "error");
            }   
        },
      }
    }
</script>

<style>
  .calltoact {
    font-family: 'Noto Serif';
    font-size: 20px;
    background-color: #502D5C;
    width: fit-content; 
    border-radius: 5px;
    width: 50%;
    height: 40px;
    margin: 0 auto;
    cursor: pointer;
  }

  .bt {
    color: #BBBABC !important;
    padding: 5px;
  }

  .buyC {
    text-align: center;
  }
  .img_size {
    width: 380px;
    height: 500px;
    border-radius: 5px;
  }
  .img_container {
    padding: 3px;
  }
  .item_bouqet {
    margin: 0 auto;
  }
  .item_bouqet:nth-child(2) {
    margin-left: 65px;
    margin-right: 65px;
  }
  .h-text {
    text-align: center;
    margin: 0 auto;
    font-family: 'Pacifico';
    font-size: 32px;
    line-height: 140%;
    color: #502D5C;
    width: 100%;
  }
  .cat-h {
    font-family: 'Pacifico';
    font-size: 24px;
    line-height: 140%;
    color: #502D5C;
    text-align: center;
    margin: 0 auto;
    margin-bottom: 20px;
    cursor: pointer;
  }

  @media screen and (min-width: 1200px) and (max-width: 1399.98px) {
        .header_adv {
            font-size: 30px;
        }
        .text-adv {
            font-size: 18px;
        }
    }
    @media screen and (min-width: 992px) and (max-width: 1199.98px) {
        .header_adv {
            font-size: 22px;
        }
        .text-adv {
            font-size: 14px;
        }
        .svg-icon {
            width: 50%;
            margin: 0 auto;
        }
    }
    @media screen and (min-width: 598px) and (max-width: 991.98px) {
        .header_adv {
            font-size: 18px;
        }
        .text-adv {
            font-size: 14px;
        }
        .svg-icon {
            width: 50%;
            margin: 0 auto;
        }
        .h-adv {
            margin: 0 auto;
            text-align: center;
        }
    }

    @media screen and (min-width: 530px) and (max-width: 797.98px) {
        .header_adv {
            font-size: 18px;
        }
        .text-adv {
            font-size: 16px;
            margin-bottom: 10px;
        }
        .svg-icon {
            width: 50%;
            margin: 0 auto;
        }
        .adv_container {
            flex-direction: column;
        }
        .h-adv {
            margin: 0 auto;
            text-align: center;
        }
    }

    @media screen and (min-width: 530px) and (max-width: 597.98px) {
        .header_adv {
            font-size: 18px;
        }
        .text-adv {
            font-size: 16px;
            margin-bottom: 10px;
        }
        .svg-icon {
            width: 50%;
            margin: 0 auto;
        }
        .adv_container {
            flex-direction: column;
        }
        .h-adv {
            margin: 0 auto;
            text-align: center;
        }
    }
</style>