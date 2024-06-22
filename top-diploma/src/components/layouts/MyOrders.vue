<!-- Блок заказов пользовтеля в его профиле -->
<template>
    <section class="d-flex mb-5 mt-5 flex-column col-lg-12 col-md-12 col-sm-12">
            <ul v-for="(order, index) in this.orders" :key="index" class="list list_bord mb-3">
                <li class="d-flex justify-content-between mt-3 order_prop">
                    <div class="d-flex order_info">
                        <span class="order_text me-5">{{order.name}}</span>
                        <address class="order_text me-5">{{ order.adress }} <br> {{ order.phone }}</address>
                    </div>
                    <div v-for="(product, index) in order.products" :key="index" class="d-flex flex-column me-5 mb-5 order_prod">
                        <h6 class="mb-3 order_head">{{ product.name }}</h6>
                        <img :src="product.picture" class="img_size_basket mb-3" alt="Образец букета">
                        <span class="order_text mb-3">{{ product.price }} руб.</span>
                    </div>
                    <div class="ask_order me-3" @click="ShowEl">Повторим?</div>
                </li>
                <li>
                    <div class="d-flex justify-content-between purch_order" v-if="isVisible">
                        <form class="d-flex flex-column ord_f" action="post">
                            <input class="order_form mb-3" type="text" v-model="name" placeholder="Имя">
                            <input class="order_form mb-3" type="phone" v-model="phone" placeholder="Номер телефона"> 
                            <div class="mb-3 w-100 ship_ord">
                                <input class="delivery_type_ord ms-4" id="delivery_choice" :value="true" v-model="delivery" type="radio">
                                <label class="me-4 empty_text ms-2" for="delivery_choice">Доставка</label>
                                <input class="delivery_type_ord" id="selfshipment" :value="false" v-model="delivery" type="radio">
                                <label class="empty_text ms-2" for="selfshipment">Самовывоз</label>
                            </div> 
                            <textarea class="order_form mb-3" name="" id="" v-model="adress" v-if="delivery" cols="30" rows="10" placeholder="Адрес доставки"></textarea>
                            <div class="send_order mb-3 order_repeat" @click="repeatOrder">Оформить</div>
                        </form>
                        <div>
                            <div v-for="(product, index) in order.products" :key="index" class="d-flex flex-column me-5 bask_f">
                                <h4 class="mb-3 order_heading2">{{ product.name }}</h4>
                                <img :src="product.picture" class="img_size_order mb-3" alt="Образец букета">
                                <span class="order_text mb-3">{{ product.price }} руб.</span>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
            
    </section>
</template>

<script>
    
    import axios from 'axios';  //   Импортируем аксиос 
    import { baseUrl } from '../../services/config';    // Импортируем префикс внешнего api
    import { baseUrlStorage } from '../../services/config'; //  Импортируем префикс для получения изображений

    export default {
    name: 'MyOrders',
    components: {
        
    },
    data(){
        return {
            orders: [], //  Возвращаем массив заказов
            phone: '',  
            adress: null,
            delivery: false,    // Возвращаем данные о пользователе в заказе
            name:'',
            product_id:[],  // массив товаров по ид
            isVisible: false,   // По умолчанию видит все свои заказы, если хочет повторить, то показываем форму оформления заказа
        }
      },
      async created(){
        this.getOrders();   // Получаем заказы пользователя
      },
      methods:{
        getOrders() {   // Метод получения заказов авторизованного пользователя
          axios.defaults.headers.common['Authorization'] = 'Bearer '+ localStorage.getItem('token');
                axios.get(baseUrl + 'api/order/getOrders').then(response => { 
                  let orders = response.data.orders.map((item, index) => {  // Объявляем переменную заказов, в которой перебираем массив заказов, полученный с сервера для данного пользователя
                        return {
                            id: item.id,
                            name: this.name = item.name,
                            phone: this.phone = item.phone,
                            adress: this.adress = item.adress,                  // Возвращаем нужные нам данные из заказа
                            delivery: item.delivery,
                            products: item.products.map((data, index) => {
                                    return {
                                    id: this.product_id = data.id,
                                    price: data.price,
                                    name:data.name,
                                    picture:baseUrlStorage + data.picture
                                }                            
                            }),
                        }
                    }); 
            
                    this.orders = orders;   // Заполняем пустой массив полученными данными
                    orders.forEach(order => {   // Перебираем заказы 
                        let array = []; // Объявляем пустой массив 
                        order.products.forEach(product => { // Перебираем каждый заказ и добавляем к нему товары
                            array.push(product.id);
                        })
                        this.product_id = array;    // заполняем пустой массив товаров товарами, которые пользователь решил перезаказать
                    });
                    return orders;  // Возвращаем заполненные заказы
                })
           },
           repeatOrder() {  // Метод для повтора заказа
            axios.post(baseUrl + 'api/order/makeOrderByUser', { // Заполняем форму оформления заказа, который хотим повторить и отправляем
                name:this.name,
                phone:this.phone,
                adress: this.adress,
                delivery: this.delivery,
                product_id: this.product_id,
                user_id: this.user_id
            }).then(response => {
                    
                }) 
           },
           ShowEl() {
            this.isVisible = !this.isVisible;   // если пользователь хочет повторить заказ показываем форму оформления заказа
           }
      }
  }
</script>

<style>
    .list {
        list-style-type: none;
        margin: 0 auto;
    }
    .order_text {
        font-family: 'Noto Serif';
        font-size: 20px;
        line-height: 140%;
        color: #502D5C;
        text-align: center;
    }
    .list_bord {
        border: 2px solid #502D5C;
        border-radius: 5px;
    }
    .order_head {
        font-family: 'Pacifico';
        font-size: 18px;
        line-height: 140%;
        color: #502D5C;
        text-align: center;
        margin: 0 auto;
    }
    .ask_order {
        font-family: 'Noto Serif';
        font-size: 20px;
        line-height: 140%;
        color: #BBBABC;
        text-align: center;
        background-color: #502D5C;
        width: 135px;
        height: 40px;
        padding-top: 5px;
        border-radius: 5px;
        cursor: pointer;
    }
    .order_repeat {
        margin-left: 100px;
    }
    .order_heading2 {
        font-family: 'Pacifico';
        font-size: 26px;
        line-height: 140%;
        color: #502D5C;
        text-align: center;
        margin: 0 auto;
    }
    .img_size_order {
        width: 250px;
        height: 330px;
        border-radius: 5px;
    }
    .delivery_type_ord {
        transform:scale(1.3);
        opacity:0.9;
    }
    @media screen and (max-width: 920.98px) 
    {
        .list {
            width: 80%;
        }
        .order_text {
            font-size: 18px;
        }
        .ask_order {
            font-size: 18px;
            padding-top: 7px;
        }
        .order_repeat {
            font-size: 18px;
        }
        .send_order {
            width: 140px;
        }
        .empty_text {
            font-size: 18px;
        }
        .order_heading2 {
            font-size: 24px;
        }
    }
    @media screen and (max-width: 916.98px) 
    {
        .list {
            width: 90%;
        }  
    }
    @media screen and (max-width: 887.98px) 
    {
        .list {
            width: 95%;
        }  
    }
    @media screen and (max-width: 863.98px) 
    {
        .order_info {
            flex-direction: column;
        }
        .order_prop {
            flex-direction: column;
            align-items: center;
        }
        .ask_order {
            margin: 0 0 20px 0 !important;
        }
        .order_prod {
            margin: 0 !important;
        }
        .order_text {
            margin: 0 0 20px 0 !important;
        }
        .purch_order {
            flex-direction: column;
            align-items: center;
        }
        .bask_f {
            margin: 0 auto !important;
        }
        .order_repeat {
            margin: 0 0 20px 0 !important;
            align-self: center;
        }
        .list {
            width: 70%;
        }
    }
    @media screen and (max-width: 767.98px) 
    {
         .img_size_basket {
            margin: 0 auto;
         }
         .order_form {
            width: 100%;
         }
         .empty_text {
            font-size: 16px;
         }
         .img_size_order {
            width: 100%;
            height: 100%;
         }
         .list {
            width: 100%;
         }
    }
    @media screen and (max-width: 539.98px) 
    {
        .empty_text {
            font-size: 16px;
         }
         .delivery_type_ord {
            margin: 0 auto !important;
         } 
    }
    @media screen and (max-width: 529.98px) 
    {
        .img_size_order {
            width: 70%;
            margin: 0 auto;
         } 
         .list {
            width: 95%;
         }
         .ask_order {
            font-size: 16px;
            padding-top: 8px;
            width: 125px;
        }
        .order_repeat {
            font-size: 16px;
            padding-top: 8px;
            width: 50%;
        }
    }
</style>