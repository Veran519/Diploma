<!-- Блок с информацией о конкретном товаре -->
<template>
    <section class="mb-5 p-3">
        <div class="card_info">
            <div class="prod_item d-flex justify-content-between" >
              <div class="img_container">
                <a :href="'http://127.0.0.1:8000/storage/' + product.picture" data-lightbox="product.picture" data-title="My caption"><img class="pic_opt mb-2" :src="'http://127.0.0.1:8000/storage/' + product.picture" alt="Превью Товара"></a>
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
    import { getProductsById } from "../services/ApiMethods";   // Импортируем функцию получения товаров по его ид с апи
    import { toast } from 'vue3-toastify';

    export default {
      name: 'ProductInfo',
      components: {
        
      },
      data(){
        return {
            product: [],    // Возвращаем массив товаров
        }
      },
      async created(){
        this.product = await this.getProductsById();    // Получаем выбранный товар в соответствии с его ид
      },
      methods:{
        async getProductsById() {   // Метод получения товара по id
          try {
          let product = await getProductsById(this.$route.params.id); // Получаем выбранный товар
            product = product.data.products;

            return product; // Обновляем массив товаров, записывая полученный в него
          } catch (error) {   // Если товар не найден, то выводим ошибку
              toast.error('Ошибка обнаружения товара!');    
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
  @media screen and (max-width: 767.98px) 
    {
        .prod_item {
          align-items: center;
        }
        .prod_desc {
          text-align: center;
          margin: 0 auto;
        }
    }
    @media screen and (max-width: 529.98px) 
    {
        .prod_item {
          flex-direction: column;
        }
    }
    @media screen and (max-width: 457.98px) 
    {
      .img_container {
        margin: 0;
      }
    }
    @media screen and (max-width: 443.98px) 
    {
      .pic_opt {
        width: 100%;
        height: 100%;
      }
    }
</style>