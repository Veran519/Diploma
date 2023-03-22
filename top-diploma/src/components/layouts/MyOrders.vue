<template>
    <section class="d-flex mb-5 mt-5 flex-column">
            <ul v-for="(order, index) in this.orders" :key="index" class="list list_bord mb-3">
                <li class="d-flex justify-content-between mt-3">
                    <div class="d-flex">
                        <span class="order_text me-5">{{order.name}}</span>
                        <address class="order_text me-5">{{ order.adress }} <br> {{ order.phone }}</address>
                    </div>
                    <div v-for="(product, index) in order.products" :key="index" class="d-flex flex-column me-5 mb-5">
                        <h6 class="mb-3 order_head">{{ product.name }}</h6>
                        <img :src="product.picture" class="img_size_basket mb-3" alt="Образец букета">
                        <span class="order_text mb-3">{{ product.price }} руб.</span>
                    </div>
                    <div class="ask_order me-3" @click="ShowEl">Повторим?</div>
                </li>
                <li>
                    <div class="d-flex justify-content-between" v-if="isVisible">
                        <form class="d-flex flex-column" action="post">
                            <input class="order_form mb-3" type="text" v-model="name" placeholder="Имя">
                            <input class="order_form mb-3" type="phone" v-model="phone" placeholder="Номер телефона"> 
                            <div class="mb-3 w-100">
                                <input class="delivery_type ms-4" id="delivery_choice" :value="true" v-model="delivery" type="radio">
                                <label class="me-4 empty_text ms-2" for="delivery_choice">Доставка</label>
                                <input class="delivery_type" id="selfshipment" :value="false" v-model="delivery" type="radio">
                                <label class="empty_text ms-2" for="selfshipment">Самовывоз</label>
                            </div> 
                            <textarea class="order_form mb-3" name="" id="" v-model="adress" v-if="delivery" cols="30" rows="10" placeholder="Адрес доставки"></textarea>
                            <div class="send_order mb-3 order_repeat" @click="repeatOrder">Оформить</div>
                        </form>
                        <div>
                            <div v-for="(product, index) in order.products" :key="index" class="d-flex flex-column me-5">
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
    
    import axios from 'axios';
    import { baseUrl } from '../../services/config';
    import { baseUrlStorage } from '../../services/config';

    export default {
    name: 'MyOrders',
    components: {
        
    },
    data(){
        return {
            orders: [],
            phone: '',
            adress: null,
            delivery: false,
            name:'',
            product_id:[],
            isVisible: false,
        }
      },
      async created(){
        this.getOrders();
      },
      methods:{
        getOrders() {
          axios.defaults.headers.common['Authorization'] = 'Bearer '+ localStorage.getItem('token');
                axios.get(baseUrl + 'api/order/getOrder').then(response => { 
                  let orders = response.data.order.map((item, index) => {
                        return {
                            id: item.id,
                            name: this.name = item.name,
                            phone: this.phone = item.phone,
                            adress: this.adress = item.adress,
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
            
                    this.orders = orders;
                    console.log(orders);
                    orders.forEach(order => {
                        let array = [];
                        order.products.forEach(product => {
                            array.push(product.id);
                            
                        })
                        this.product_id = array;
                    });
                    console.log(this.product_id)
                    return orders;
                })
           },
           repeatOrder() {
            axios.post(baseUrl + 'api/order/makeOrderByUser', {
                name:this.name,
                phone:this.phone,
                adress: this.adress,
                delivery: this.delivery,
                product_id: this.product_id,
                user_id: this.user_id
            }).then(response => {
                    console.log(response);
                }) 
           },
           ShowEl() {
            this.isVisible = !this.isVisible;
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
</style>