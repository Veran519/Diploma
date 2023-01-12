import { createApp } from 'vue'
import { createPinia } from 'pinia'

import App from './App.vue'
import router from './router'
import axios from "axios"
import VueAxios from 'vue-axios'
import './assets/main.css'
import VueAwesomeSwiper from 'vue-awesome-swiper'
import 'swiper/swiper-bundle.css'

const app = createApp(App)

app.use(createPinia())
app.use(router)

app.mount('#app')
app.use(VueAxios, axios)
app.use(VueAwesomeSwiper)

