import { createApp } from 'vue'
import { createPinia } from 'pinia'

import App from './App.vue'
import router from './router'
import axios from "axios"
import VueAxios from 'vue-axios'
import './assets/main.css'
import VueAwesomeSwiper from 'vue-awesome-swiper'
import 'swiper/swiper-bundle.css'
import { store } from './store/index.js'
import Vue3Toastify from 'vue3-toastify';
import 'vue3-toastify/dist/index.css'

const app = createApp(App)

app.use(createPinia())
app.use(store)
app.use(router)
app.use(Vue3Toastify, {
  // здесь вы можете указать глобальные настройки, например:
  position: 'top-right',
  timeout: 3000
});

app.mount('#app')
app.use(VueAxios, axios)
app.use(VueAwesomeSwiper)

axios.defaults.withCredentials = true;

