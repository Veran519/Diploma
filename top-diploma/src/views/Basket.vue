<!-- Блок корзины с товарами и оформления заказов -->
<template>
    <section class="container col-lg-12 col-md-12 col-sm-12">
        <h2 class="basket_heading mb-5">Корзина</h2>
        <div class="purchase_items d-flex justify-content-between">
            <div class="basket_items">
                <div class="list_item">
                    <h4 class="purchases_heading mb-4">Всего товаров:</h4>
                    <div class="d-flex mb-5 prod_in_bask" v-for="(product, index) in this.basket" :key="index">
                        <h6 class="me-5 bask_head">{{product.name}}</h6>
                        <img :src="product.picture" class="img_size_basket me-5 img_in_bask" alt="миниатюра покупки">
                        <span class="me-5 bask_text">Цена: {{product.price}} Руб.</span>
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
                <div class="mb-3 d-flex del_prop">
                    <input class="delivery_type ms-4 del_t" id="delivery_choice" :value="true" v-model="delivery" type="radio">
                    <label class="me-4 empty_text ms-2 del_text" for="delivery_choice">Доставка</label>
                    <input class="delivery_type del_t" id="selfshipment" :value="false" v-model="delivery" type="radio">
                    <label class="empty_text ms-2 del_text" for="selfshipment">Самовывоз</label>
                </div>
                <form class="d-flex flex-column ord_f">
                    <input class="order_form ord_name" type="text" id="name" v-model="name"  placeholder="Имя">
                    <label class="error_name" v-for="items in errors.name" v-if="errors.name" for="name">{{ items }}</label>
                    <input class="order_form hidden" type="tel" id="phone" v-model="telphone" placeholder="+7 (___) ___-____">
                    <MaskInput v-model="phone" mask="+ 7 (###) ###-##-##" class="i-form order_form ord_phone" placeholder="+7 (___) ___-____"/>  
                    <label class="error_phone" v-for="items in errors.phone" v-if="errors.phone" for="phone">{{ items }}</label> 
                    <textarea class="order_form ord_adr" name="" id="adress" v-model="adress" cols="30" rows="10" v-if="delivery" placeholder="Адрес доставки"></textarea>
                    <label class="error_adress" v-for="items in errors.adress" v-if="errors.adress" for="adress">{{ items }}</label> 
                    <div class="send_order ord_send" @click="sendOrder">Отправить</div>
                </form>
            </div>
        </div>     
    </section>
</template>
  
<script>
    //import axios from "axios";      // Импортируем аксиос
    import { getProductsInBasket } from "../services/ApiMethods";   // Импортируем функцию получения товаров в корзине 
    import { makeOrder } from "../services/ApiMethods";     // импортируем функцию оформления заказа
    import { baseUrlStorage } from '../services/config.js'; // Импортируем префикс для хранилища изображений
    import { baseUrl } from "../services/config.js";    // Импортируем путь к api
    import { toast } from 'vue3-toastify';
    import { MaskInput } from 'vue-3-mask';
    

    export default {
      name: 'Basket',
      components: {
        MaskInput,
      },
      props: ['Myname', 'Myphone', 'Myadress'],     // Получаем пропсы из компоненты информации о пользователе
      data(){
        return {
            basket: [],
            name: '',
            phone: '',
            adress: '',             // Возвращаем данные о наполненнии корзины, а также данные формы оформления заказа и ошибки
            delivery: false,
            //user_id: null,
            telphone:'',
            errors: {
                name:'',
                phone:'',
                adress:'',
            }
        }
      },
      async created() {
        this.basket = await this.getBasketProducts();   // Получаем наполняемость корзины по товарам
        /*this.getUserData(); // Получаем данные пользователя, если он авторизован и не является гостем*/
      },
      methods: {
       async getBasketProducts() {      // Метод получения товаров в корзине
            const basket = JSON.parse(localStorage.basket);     // Конвертируем товары из локального хранилища, которые были добавлены в корзину
            const productsInBasket = await getProductsInBasket(basket); // Получаем товары все товары в корзине

            const productInBasket = productsInBasket.data.product.map((item, index) => {    // Перебираем массив товаров в корзине 
                return {
                    id: item.id,
                    picture: baseUrlStorage + item.picture,
                    price: item.price,
                    name: item.name,
                }
            });

            return productInBasket;     // Возвращаем все товары
        },
        DeleteProductFromBasket(id) {   // Метод очистки корзины
            const basket = JSON.parse(localStorage.basket); // Конвертируем товары из локального хранилища, которые были добавлены в корзину
            const index = basket.indexOf(id);   // удаляем товар по его id
            if(index > -1) {
                basket.splice(index, 1);
            }
            
            localStorage.setItem('basket', JSON.stringify(basket));     // Меняем состояние локального хранилища корзины и конвертируем изменненое обратно
            this.basket = this.basket.filter(item => item.id !== id);   // Обновляем содержимое корзины
        },
        async sendOrder() {   // Метод отправки оформленного заказа
        try { 
          if(!localStorage.getItem('token')) {
            const ordersData = await makeOrder({  // Если гость, то выполняем код ниже
            name: this.name,
            phone: this.telphone = this.phone.replace(/[^0-9]/g, ''),
            adress: this.adress,
            delivery: this.delivery,
            product_id: this.basket.map((item) => {return item.id})
          });
          toast.success('Ваш заказ успешно сформирован!');
          this.clearBasket();
        }
          /*if(localStorage.getItem('token')) {       // если пользователь авторизован, выполняем код ниже
            axios.post(baseUrl + 'api/order/makeOrderByUser', {
                name:this.name,
                phone:this.telphone = this.phone.replace(/[^0-9]/g, ''),
                adress: this.adress,
                delivery: this.delivery,
                product_id: this.basket.map((item) => {return item.id}),
                user_id: this.user_id
            }).then(response => {
                toast.success('Ваш заказ успешно сформирован!');
                }).catch(err => {       //  Если форма была заполнена с ошибками, то показываем их пользователю
                    if(err.response.status === 422) {
                        console.log(err.response.data.errors);
                        this.errors.name =  err.response.data.errors.name;
                        this.errors.phone = err.response.data.errors.phone;
                        this.errors.adress = err.response.data.errors.adress;
            }
            toast.error('Одно или несколько полей были заполнены неверно!');
                }) 
          }*/ 
        } catch (error) {
            if(!localStorage.getItem('token')) {        // Вывод ошибок для неавторизованного пользователя
                if(error.response.status === 422) {
                this.errors.name =  error.response.data.errors.name;
                this.errors.phone = error.response.data.errors.phone;
                this.errors.adress = error.response.data.errors.adress;
            }
            toast.error('Одно или несколько полей были заполнены неверно!');
            }
            }  
        },
        /*getUserData() {     //  Метод получения информации о пользователе
            if(localStorage.getItem('token')) {
                axios.get(baseUrl + 'api/user').then(response => {
                    this.name = response.data.name;
                    this.phone = response.data.phone;
                    this.adress = response.data.adress;
                    this.user_id = response.data.id;
                }) 
          }
        },*/
        clearBasket() {
            // Очистка массива корзины
            this.basket = [];
            // Очистка записи корзины в localStorage
            localStorage.removeItem('basket');
        }
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
    .bask_head {
        font-family: 'Pacifico';
        font-size: 18px;
        line-height: 140%;
        color: #502D5C;
    }
    .bask_text {
        font-family: 'Noto Serif';
        font-size: 20px;
        line-height: 140%;
        color: #502D5C;
    }
    .ord_send {
        margin: 0 auto;
    }
    .error_name {
        font-family: 'Noto Serif';
        font-size: 16px;
        line-height: 140%;
        color: #c70c25;
        margin-bottom: 3px;
    }
    .error_phone {
        font-family: 'Noto Serif';
        font-size: 16px;
        line-height: 140%;
        color: #c70c25;
        margin-bottom: 4px;
    }
    .error_adress {
        font-family: 'Noto Serif';
        font-size: 16px;
        line-height: 140%;
        color: #c70c25;
        margin-bottom: 5px;
    }
    .ord_adr {
        margin-bottom: 5px;
    }
    .ord_name {
        margin-bottom: 5px;
    }
    .ord_phone {
        margin-bottom: 5px;
    }
    @media screen and (max-width: 992.98px) 
    {
        .prod_in_bask {
            flex-direction: column;
        }
        .img_in_bask {
            margin: 0 0 10px 0 !important;
        }
        .bask_head {
            text-align: center;
            margin: 0 0 10px 0 !important;
        }
        .bask_text {
            text-align: center;
            margin: 0 0 10px 0 !important;
        }
        .del_btn {
            text-align: right;
            margin-bottom: 10px;
            order: -1;
        }
    }
    @media screen and (max-width: 767.98px) 
    {
        .img_in_bask {
            width: 100%;
            height: 100%;
        }
        .del_prop {
            flex-direction: row;
        }
        .ord_send {
            margin-bottom: 20px;
        }
    }
    @media screen and (max-width: 529.98px) 
    {
        .purchase_items {
            flex-direction: column;
        }
        .ord_f {
            width: 80%;
            margin: 0 auto;
        }
       .del_t {
        margin: 0 0 0 70px !important;
       }
    }
    @media screen and (max-width: 435.98px) 
    {
       .del_t {
        margin: 0 0 0 50px !important;
       }
    }
    @media screen and (max-width: 389.98px) 
    {
       .del_t {
        margin: 0 0 0 40px !important;
       }
       .error_adress {
        font-size: 14px;
       }
       .error_name {
        font-size: 14px;
       }
       .error_phone {
        font-size: 14px;
       }
    }
    @media screen and (max-width: 370.98px) 
    {
       .del_t {
        margin: 0 0 0 30px !important;
       }
    }
</style>