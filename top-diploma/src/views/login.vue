<!-- Блок авторизации пользователя, форма для входа в свой профиль -->
<template>
    <section class="container col-lg-12 col-md-8 col-sm-4">
        <form class="login">
            <div class="mb-1 log_item">
                <label for="exampleInputEmail1" class="form-label_log mb-1">Введите ваш логин</label>
                <input type="email" v-model="email" class="form-control log_form"  aria-describedby="emailHelp">
                <span class="error" v-for="items in errors.email" v-if="errors.email">{{ items }}</span>
            </div>
            <div class="mb-3 log_item">
                <label for="exampleInputPassword1" class="form-label_log mb-1">Пароль</label>
                <input type="password" v-model="password" class="form-control log_form">
                <span class="error" v-for="items in errors.password" v-if="errors.password">{{ items }}</span>
            </div>
            <div type="submit" @click="Enter" class="btn_log mb-5">Вход</div>
        </form>
    </section>
</template>

<script>
import axios from 'axios';  // Импорт аксиоса
import { baseUrl } from '../services/config';   // Импорт api
import { toast } from 'vue3-toastify';

    export default {
      name: 'login',
      components: {
        
      },
      data(){
        return {
           email: null,
           password: null,      // Возвращаем логин и пароль, а также ошиюки при заполнении формы
           errors: {
            email:'',
            password:''
           }
        }
      },
      methods: {
           Enter() {    // Метод авторизации пользователя
            axios.get(baseUrl + 'sanctum/csrf-cookie').then(response => {   // Получаем через аксисо csrf куки
                axios.post(baseUrl + 'api/login', {     // Заполняем форму авторизации и отправляем данные
                    email: this.email,
                    password: this.password
                }).then(response => {
                    localStorage.setItem('token', response.data.token);
                    if(response.data.status == 404) {
                       this.errors.email = response.data.message;
                    }                                                       // Выводим ошибки в зависимости от их статуса
                    if(response.data.status == 422) {
                       this.errors.password = response.data.message;
                    }
                    this.$store.commit('changeState', true);    // Меняем состояние через вьюкс с Регистрации на Профиль
                    if(response.data.status == 202) {
                        this.$router.push('/Profile');
                    }
                    toast.error('Одно или несколько полей были заполнены неверно!');
                }).catch(error => {             // Ловим ошибки при заполнении и выводим их пользователю
                    if(error.response.status === 422) {
                        console.log(error.response.data.errors);
                        this.errors.email = error.response.data.errors.email;
                        this.errors.password = error.response.data.errors.password;
                    }
                    toast.error('Одно или несколько полей были заполнены неверно!');
                })
            });
           }   
      }
    }
</script>

<style>
    .log_item {
       margin: 0 auto;
    }
    .btn_log {
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
        width: 15%;
    }
    .log_form {
        background-color: #9D6796;
        border-radius: 5px;
        border: 2px solid black;
        width: 100%;
    }
    .form-label_log {
        font-family: 'Noto Serif';
        font-size: 16px;
        line-height: 140%;
        color: #502D5C;
    }
    .login {
        width: 70%;
        margin: 0 auto;
    }
    @media screen and (max-width: 590.98px) 
    {
        .btn_log {
            width: 20%;
        }
    }
    @media screen and (max-width: 469.98px) 
    {
        .btn_log {
            width: 30%;
        }
    }
    @media screen and (max-width: 370.98px) 
    {
        .btn_log {
            width: 30%;
        }
        .login {
            width: 100%;
        }
    }
</style>