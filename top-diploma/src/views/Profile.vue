<template>
    <section class="">
        <div class="links">
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
import axios from 'axios';
import { baseUrl } from '../services/config';

    export default {
      name: 'Profile',
      components: {
        
      },
      data(){
        return {
           
        }
      },
      methods: {
           logout() {
                axios.post(baseUrl + 'api/logout').then(response => {
                    localStorage.removeItem('token');
                    this.$store.commit('changeState', false);
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
</style>