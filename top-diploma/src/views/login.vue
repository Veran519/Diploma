<template>
    <section>
        <form class="login">
            <div class="mb-3 log_item">
                <label for="exampleInputEmail1" class="form-label">Введите ваш логин</label>
                <input type="email" v-model="email" class="form-control reg_form"  aria-describedby="emailHelp">
            </div>
            <div class="mb-3 log_item">
                <label for="exampleInputPassword1" class="form-label">Пароль</label>
                <input type="password" v-model="password" class="form-control reg_form">
            </div>
            <div type="submit" @click="Enter" class="btn_log mb-5">Вход</div>
        </form>
    </section>
</template>

<script>
import axios from 'axios';
import { baseUrl } from '../services/config';

    export default {
      name: 'login',
      components: {
        
      },
      data(){
        return {
           email: null,
           password: null
        }
      },
      methods: {
           Enter() {
            axios.get(baseUrl + 'sanctum/csrf-cookie').then(response => {
                axios.post(baseUrl + 'api/login', {
                    email: this.email,
                    password: this.password
                }).then(response => {
                    localStorage.setItem('token', response.data.token);
                    this.$store.commit('changeState', true);
                    this.$router.push('/Profile');
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
        width: 35vh;
    }
    .log_form {
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
</style>