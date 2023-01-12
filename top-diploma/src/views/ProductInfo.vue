<template>
    <section class="mb-5 p-3">
        <div class="card_info">
            <div class="prod_item d-flex justify-content-between" v-for="(product, index) in this.product" :key="index">
              <div class="img_container">
                <img class="pic_opt mb-3" :src="product.picture" alt="">
              </div>
                <div class="prod_desc">
                    <h4>Описание товара</h4>
                    <div>
                        <p>{{product.description}}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
    import { baseUrlStorage } from "../services/config.js";
    import { getProductsById } from "../services/ApiMethods";

    export default {
      name: 'ProductInfo',
      components: {
        
      },
      data(){
        return {
            product: []
        }
      },
      async created(){
        this.product = await this.getProductsById();
      },
      methods:{
        async getProductsById() {
          try {
          let product = await getProductsById(this.$route.params.id);
            product = product.data.products.map((item, index) => {
                return {
                    name: item.name,
                    id: item.id,
                    price: item.price,
                    category_id: item.category_id,
                    picture: baseUrlStorage + item.picture,
                    isActual:item.isActual,
                    isAvailable: item.isAvailable,
                    description: item.description
                };
            });
                  
            return product;
          } catch (error) {
              alert("Товары не обнаружены!", "error");
            }   
        },
      }
    }
</script>

<style>
  .pic_opt {
    width: 400px;
    height: 500px;
    border-radius: 12px;
    padding-left: 6px;
    padding-right: 6px;
    padding-top: 6px;
  }
  .img_container {
    margin-left: 10px;
  }
  .buy_Cl {
      margin: 0 auto;
      font-family: 'Noto Serif';
      font-size: 20px;
      line-height: 140%;
      color: #BBBABC;
      text-align: center;
      background-color: #502D5C;
      width: 120px;
      height: 40px;
      padding-top: 5px;
      border-radius: 5px;
      cursor: pointer;
  }
  .prod_desc {
    margin-right: 50px;
    padding: 10px 0;
  }
  .card_info {
    border: 2px solid #502D5C;
    background-color: #EFDAE8;
    margin: 0 auto;
    border-radius: 5px;
  }
</style>