<template>
    <section>
        <form class="registr" action="post">
            <div class="mb-3 reg_item">
                <label for="name" class="form-label">Укажите Ваше имя</label>
                <input type="text" v-model="name" class="form-control reg_form" id="name">
            </div>
            <div class="mb-3 reg_item">
                <label for="exampleInputEmail1" class="form-label">Укажите Ваш адрес электронной почты</label>
                <input type="email" v-model="email" class="form-control reg_form" id="exampleInputEmail1" aria-describedby="emailHelp">
            </div>
            <div class="mb-3 reg_item">
                <label for="exampleInputPassword1" class="form-label">Придумайте пароль</label>
                <input type="password" v-model="password" class="form-control reg_form" id="exampleInputPassword1">
            </div>
            <div class="mb-3 reg_item">
                <label for="exampleInputPassword2" class="form-label">Подвердите пароль</label>
                <input type="password" v-model="password_confirm" class="form-control reg_form" id="exampleInputPassword2">
            </div>
            <div type="submit" @click="registr" class="btn_col mb-5">Зарегистрироваться</div>
            <div class="or mb-5">
                <span>ИЛИ</span>
            </div>       
            <div class="btn_auth mb-5" @click="this.$router.push('/login')">Войти</div>
        </form>
    </section>
</template>

<script>
    import axios from 'axios';
    import { baseUrl } from '../services/config';

    export default {
      name: 'Registration',
      components: {
        
      },
      data(){
        return {
           name: null,
           email: null,
           password: null,
           password_confirm: null 
        }
      },
      async created() {
        
      },
      methods: {
            registr() {
                axios.get(baseUrl + 'sanctum/csrf-cookie').then(response => {
                    axios.post(baseUrl + 'api/registration', {
                        name: this.name,
                        email: this.email,
                        password: this.password,
                        password_confirm: this.password_confirm
                    }).then(response => {
                        console.log(response);
                    })
            })
        }
      }
    }
</script>

<style>
    .reg_item {
        margin: 0 auto;
    }
    .btn_col {
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
        width: 35vh;
    }
    .reg_form {
        background-color: #9D6796;
        border-radius: 5px;
        border: 2px solid black;
        width: 50vh;
        margin: 0 auto;
    }
    .form-label {
        margin-left: 197px;
        font-family: 'Noto Serif';
        font-size: 16px;
        line-height: 140%;
        color: #502D5C;
        word-wrap: break-word;
    }
    .btn_auth {
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
        width: 15vh;
    }
    .or {
        margin: 0 auto;
        text-align: center;
        font-family: 'Noto Serif';
        font-size: 20px;
        line-height: 140%;
        color: #502D5C;
        word-wrap: break-word;
    }
</style>