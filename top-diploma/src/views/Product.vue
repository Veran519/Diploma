<template>
    <section class="container">
        <h2 class="p-heading mb-5">Каталог</h2>
        <section class="container">
            <section v-for="(product, index) in this.productsById" :key="index">
                <div>
                    <h3 class="cat_heading mb-5">{{product.name}}</h3>
                </div>
                <div class="d-flex">
                    <section class="d-flex" v-for="(item, index) in product.items" :key="index">
                        <div class="card_item me-4 mb-5">
                            <img class="pic_prop mb-4" :src="item.picture" alt="фото букета">
                            <div class="mb-4 price_container">
                                <span class="p_text">Цена: {{item.price}}</span>
                            </div>
                            <div class="d-flex but_container mb-2">
                                <div class="buy_C" @click="AddToBasket(item.id)">Купить</div>
                                <div class="buy_C"  v-if="item.in_basket" @click="DeleteFromBasket(item.id)">Удалить</div>
                                <div class="about_C" @click="this.$router.push(item.link)">Подробнее</div>
                            </div>
                        </div>
                    </section>
                </div>
            </section>
        </section>
    </section>
</template>

<script>
    import { baseUrlStorage } from "../services/config.js";
    import { getProducts } from "../services/ApiMethods";
    import { getProductsByCategory } from "../services/ApiMethods";

    export default {
      name: 'Product',
      components: {
        
      },
      data(){
        return {
            products: [],
            productsById: [],
            productInBasket: false,
        }
      },
      async created(){
        this.products = await this.getProducts();
        this.productsById = await this.getProductsByCategory();
        this.productInBasket = this.checkProductInBasket();
        console.log(this.productsById);
      },
      methods:{
        async getProducts() {
          try {
          let products = await getProducts();
            products = products.data.products.map((item, index) => {
                return {
                    name: item.name,
                    id: item.id,
                    price: item.price,
                    category_id: item.category_id,
                    picture: baseUrlStorage + item.picture,
                    isActual:item.isActual,
                    isAvailable: item.isAvailable,
                    link: '/Products/ProductInfo/' + item.id
                };
            });
                  
            return products;
          } catch (error) {
              alert("Товары не обнаружены!", "error");
            }   
        },

        async getProductsByCategory() {
          try {
          let productsById = await getProductsByCategory();
            productsById = productsById.data.categories.map((item, index) => {
                return {
                    id: item.id,
                    name: item.name,
                    items: item.items.map((data, index) => {
                            return {
                            id: data.id,
                            picture: baseUrlStorage + data.picture,
                            price: data.price,
                            link: '/Products/ProductInfo/' + data.id,
                            in_basket: this.checkProductInBasket(data.id)
                        }                            
                    }),
                }
            });
            
            return productsById;
          } catch (error) {
              alert("Товары не обнаружены!", "error");
            }   
        },
        AddToBasket(id) {
            if(localStorage.basket == null) {
                let basket = [];
                basket.push(id);
                localStorage.setItem('basket', JSON.stringify(basket));
            } else {
                const basket = JSON.parse(localStorage.basket);
                basket.push(id);
                localStorage.setItem('basket', JSON.stringify(basket));
            }
            
            this.checkProductInBasket(id);
            this.productsById.forEach(category=>{
                category.items.forEach(items=>{
                    if(items.id === id) {
                        items.in_basket = this.checkProductInBasket(id);
                    }
                })
            })   
        },
        checkProductInBasket (id) {
            if (localStorage.basket == null) {
                return false;
            }

            const basket = JSON.parse(localStorage.basket);
            const product = basket.find(element => element === id);

            if (product == null) {
                return false;
            }
            return true;
        },
        DeleteFromBasket(id) {
            const basket = JSON.parse(localStorage.basket);
            const index = basket.indexOf(id);
            if(index > -1) {
                basket.splice(index, 1);
            }
            
            localStorage.setItem('basket', JSON.stringify(basket));
            this.productsById.forEach(category=>{
                category.items.forEach(items=>{
                    if(items.id === id) {
                        items.in_basket = this.checkProductInBasket(id);
                    }
                })
            })
        }
      }
    }
</script>

<style>
    .p-heading {
        font-family: 'Pacifico';
        font-size: 32px;
        font-weight: 400;
        line-height: 140%;
        color: #502D5C;
        text-align: center;
        margin: 0 auto;
        text-shadow: 4px 4px 3px rgba(0, 0, 0, 0.25);
    }
    .cat_heading {
        font-family: 'Pacifico';
        font-size: 24px;
        line-height: 140%;
        color: #502D5C;
        text-align: center;
        margin: 0 auto;
        margin-bottom: 20px;
        cursor: pointer;
    }
    .pic_prop {
        width: 400px;
        height: 500px;
        border-radius: 12px;
        padding-left: 6px;
        padding-right: 6px;
        padding-top: 6px;
    }
    .p-item {
        margin: 0 auto;
    }
    .price_container {
        text-align: center;
        margin: 0 auto;
    }
    .but_container {
        margin: 0 auto;
        justify-content: space-around;
        width: 100%;
    }
    .cat_heading {
        font-family: 'Pacifico';
        font-size: 24px;
        line-height: 140%;
        color: #502D5C;
        margin: 0 auto; 
    }
    .p_text {
        font-family: 'Noto Serif';
        font-size: 20px;
        line-height: 140%;
        color: #502D5C;
        text-align: center;
        margin: 0 auto;
    }
    .buy_C {
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
    .about_C {
        font-family: 'Noto Serif';
        font-size: 20px;
        line-height: 140%;
        color: #BBBABC;
        text-align: center;
        background-color: #502D5C;
        width: 150px;
        height: 40px;
        padding-top: 5px;
        border-radius: 5px;
        cursor: pointer;
    }
    .card_item {
        border: 2px solid #502D5C;
        background-color: #EFDAE8;
        margin: 0 auto;
        border-radius: 5px;
    }
</style>