<!-- Блок меню авторизованного пользователя -->
<template>
    <section class="col-lg-12 col-md-12 col-sm-12">
        <div class="links mb-5 prof_set">
            <router-link class="me-5 linkS" to="/ProfileInfo">Мои данные</router-link>
            <router-link class="me-5 linkS" to="/MyOrders">Мои заказы</router-link>
            <router-link type="submit" to="/login" class="linkS" @click="logout">Выход</router-link>
        </div>
        <div class="content">
            <router-view></router-view>
        </div>
    </section>
</template>

<script>
import axios from 'axios';  // Импортируем аксиос
import { baseUrl } from '../services/config';   // Импортируем api

    export default {
      name: 'Profile',
      components: {
        
      },
      data(){
        return {
           
        }
      },
      methods: {
           logout() {   // Метод выхода пользователя из своего профиля
                axios.post(baseUrl + 'api/logout').then(response => {   // Используя аксиос посылаем запрос на бэк
                    localStorage.removeItem('token');   // Удаляем токен текущей сессии для пользователя
                    this.$store.commit('changeState', false);   // изменяем состояние Профиль на Регистрацию
                }) 
           }
      }
    }
</script>

<style>
    .links {
        text-align: center;
    }
    .linkS {
        text-decoration: none;
        font-family: 'Noto Serif';
        font-size: 20px;
        line-height: 140%;
        color: #502D5C;
    }
    @media screen and (max-width: 405.98px) 
    {
        .linkS {
            margin: 0 20px 0 0!important;
        }
    }
    @media screen and (max-width: 369.98px) 
    {
        .linkS {
            font-size: 18px;
        }
    }
</style>