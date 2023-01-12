<template>
    <section class="container">
        <h2 class="basket_heading mb-5">Корзина</h2>
        <div class="purchase_items d-flex justify-content-between">
            <div class="basket_items">
                <div class="list_item">
                    <h4 class="purchases_heading mb-4">Всего товаров:</h4>
                    <div class="d-flex mb-5" v-for="(product, index) in this.basket" :key="index">
                        <h6 class="me-5">{{product.name}}</h6>
                        <img :src="product.picture" class="img_size_basket me-5" alt="миниатюра покупки">
                        <span class="me-5">Цена:{{product.price}} Руб.</span>
                        <a href="#" class="del_btn" @click="DeleteProductFromBasket(product.id)">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="32" viewBox="0 0 24 32" fill="none">
                                <path d="M21.4375 8.35821V30.1493C21.4375 31.1642 20.5625 32 19.5 32H4.46875C3.40625 32 2.53125 31.1642 2.53125 30.1493V8.35821H21.4375ZM16.5313 10.7761V29.5224H17.6562V10.7761H16.5313ZM11.4375 10.7761V29.5224H12.5625V10.7761H11.4375ZM6.34375 10.7761V29.5224H7.46875V10.7761H6.34375ZM7.59375 3.31343V1.76119C7.59375 0.77612 8.40625 0 9.4375 0H14.5625C15.5937 0 16.4062 0.77612 16.4062 1.76119V3.31343H22.0625C23.125 3.31343 24 4.14925 24 5.16418V6.44776H0V5.13433C0 4.1194 0.875 3.28358 1.9375 3.28358H7.59375V3.31343ZM9.4375 1.19403C9.125 1.19403 8.875 1.43284 8.875 1.73134V3.28358H15.1562V1.73134C15.1562 1.43284 14.9063 1.19403 14.5938 1.19403H9.4375Z" fill="#502D5C"/>
                            </svg>
                        </a>
                    </div>
                    <div v-if="!this.basket.length">
                        <span class="empty_text">В корзине пока ничего нет :(</span>
                    </div>
                </div>
            </div>
            <div class="list_item" v-if="this.basket.length">
                <h4 class="order_heading mb-4">Оформить заказ</h4>
                <div class="mb-3 d-flex">
                    <input class="delivery_type ms-4" id="delivery_choice" :value="true" v-model="delivery" type="radio">
                    <label class="me-4 empty_text ms-2" for="delivery_choice">Доставка</label>
                    <input class="delivery_type" id="selfshipment" :value="false" v-model="delivery" type="radio">
                    <label class="empty_text ms-2" for="selfshipment">Самовывоз</label>
                </div>
                <form class="d-flex flex-column" action="post">
                    <input class="order_form mb-3" type="text" v-model="name" placeholder="Имя">
                    <input class="order_form mb-3" type="phone" v-model="phone" placeholder="Номер телефона">   
                    <textarea class="order_form mb-3" name="" id="" v-model="adress" cols="30" rows="10" v-if="delivery" placeholder="Адрес доставки"></textarea>
                    <div class="send_order" @click="sendOrder">Отправить</div>
                </form>
            </div>
        </div>     
    </section>
</template>
  
<script>
    import { getProductsInBasket } from "../services/ApiMethods";
    import { makeOrder } from "../services/ApiMethods";
    import { baseUrlStorage } from '../services/config.js';

    export default {
      name: 'Basket',
      components: {
        
      },
      data(){
        return {
            basket: [],
            name: '',
            phone: '',
            adress: '',
            delivery: false,
        }
      },
      async created() {
        this.basket = await this.getBasketProducts();
      },
      methods: {
       async getBasketProducts() {
            const basket = JSON.parse(localStorage.basket);
            const productsInBasket = await getProductsInBasket(basket);

            const productInBasket = productsInBasket.data.product.map((item, index) => {
                return {
                    id: item.id,
                    picture: baseUrlStorage + item.picture,
                    price: item.price,
                    name: item.name
                }
            });

            return productInBasket;
        },
        DeleteProductFromBasket(id) {
            const basket = JSON.parse(localStorage.basket);
            const index = basket.indexOf(id);
            if(index > -1) {
                basket.splice(index, 1);
            }
            
            localStorage.setItem('basket', JSON.stringify(basket));
            /*location.reload();*/
            console.log(basket)
            this.basket = this.basket.filter(item => item.id !== id)
        },
        async sendOrder() {   
        try { 
          const ordersData = await makeOrder({
            name:this.name,
            phone:this.phone,
            adress: this.adress,
            delivery: this.delivery,
            product_id: this.basket.map((item) => {return item.id})
          });
        } catch (error) {
              alert("Ошибка формирования заказа!", "error");
            }  
        },
      }
    }
</script>

<style>
    .basket_heading {
        font-family: 'Pacifico';
        font-size: 32px;
        line-height: 140%;
        color: #502D5C;
        text-align: center;
        margin: 0 auto;
    }
    .purchases_heading {
        font-family: 'Pacifico';
        font-size: 26px;
        line-height: 140%;
        color: #502D5C;
        text-align: center;
        margin: 0 auto;
    }
    .order_heading {
        font-family: 'Pacifico';
        font-size: 26px;
        line-height: 140%;
        color: #502D5C;
        text-align: center;
        margin: 0 auto;
    }
    .order_form {
        background-color: #9D6796;
        border-radius: 5px;
        border: 2px solid black;
        width: 350px;
    }
    .order_form::placeholder {
        font-family: 'Noto Serif';
        font-size: 20px;
        color: #502D5C;
    }
    .delivery_type {
        transform:scale(1.3);
        opacity:0.9;
    }
    .img_size_basket {
        width: 180px;
        height: 230px;
    }
    .empty_text {
        font-family: 'Noto Serif';
        font-size: 20px;
        line-height: 140%;
        color: #502D5C;
        text-align: center;
        margin: 0 auto;
    }
    .send_order {
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
    .del_btn {
        text-decoration: none;
        color:#502D5C;
        font-size: 20px;
    }
</style>