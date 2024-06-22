<!-- Блок с информацией о пользователе(авторизованном) -->
<template>
    <section class="d-flex mb-5 justify-content-between mt-5 col-lg-12 col-md-12 col-sm-12">
        <form class="d-flex flex-column formSub" action="post">
            <input class="order_form mb-1 p-1" type="text" v-model="this.name" placeholder="Имя">
            <span class="error mb-1 mt-1" v-for="items in errors.name" v-if="errors.name">{{ items }}</span>
            <input class="order_form mb-1 p-1" type="phone" v-model="this.phone" placeholder="Номер телефона">
            <span class="error mt-1 mb-1" v-for="items in errors.phone" v-if="errors.phone">{{ items }}</span>   
            <textarea class="order_form mb-1 p-1" name="" id="" v-model="this.adress" cols="30" rows="10"  placeholder="Адрес доставки"></textarea>
            <span class="error mb-2" v-for="items in errors.adress" v-if="errors.adress">{{ items }}</span>
            <div type="submit" @click="updateData" class="btn btn_save">Сохранить</div>
        </form>
    </section>
</template>

<script>
    import axios from 'axios';  // Импортируем аксиос
    import { baseUrl } from '../../services/config';    // Импорируем префикс api

    export default {
      name: 'ProfileInfo',
      components: {
        
      },
      data(){
        return {
            name: '',
            phone: null,
            adress: '',         // Возвращаем данные пользователя и ошибки
            errors: {
                name:'',
                phone:null,
                adress:''
            }
        }
      },
      created() {
        if(localStorage.getItem('token')) {     // Если пользователь авторизован,  подтягиваем его данные из БД
            axios.defaults.headers.common['Authorization'] = 'Bearer '+ localStorage.getItem('token');
            axios.get(baseUrl + 'api/user').then(response => {
                    console.log(response)
                    this.name = response.data.name;
                    this.phone = response.data.phone;
                    this.adress = response.data.adress;
                }) 
          }
      },
      methods: {
            updateData() {      // Метод обновления данных о пользователе
                axios.post(baseUrl + 'api/updateUsersData', {
                    name: this.name,
                    phone: this.phone,                      // Заполняем форму с новыми данными пользователя и отправляем на сервер
                    adress: this.adress,
                }).then(response => {
                    
                }).catch(error => {
                    if(error.response.status === 422) {             // Если есть ошибки при заполнении, то ловим их и выводим пользователю
                        console.log(error.response.data.errors);
                        this.errors.name = error.response.data.errors.name;
                        this.errors.phone = error.response.data.errors.phone;
                        this.errors.adress = error.response.data.errors.adress;
            }
                })
            },
      }
    }
</script>

<style>
    .btn_save {
        margin: 0 auto;
        text-align: center;
        font-family: 'Noto Serif';
        font-size: 20px;
        line-height: 140%;
        color: #BBBABC;
        text-align: center;
        background-color: #502D5C;
        height: 40px;
        padding-top: 5px;
        border-radius: 5px;
        cursor: pointer;
        width: 25vh;
    }
    .formSub {
        margin: 0 auto;
    }
    @media screen and (max-width: 767.98px) 
    {
        .formSub {
            align-items: center;
        }
    }
    @media screen and (max-width: 380.98px) 
    {
        .btn_save {
            font-size: 18px;
            width: 20vh;
        }
        .order_form {
            width: 50vh;
        }
    }
</style>