import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import Reviews from '../views/Reviews.vue'
import Delivery from '../views/Delivery.vue'
import Product from '../views/Product.vue'
import ProductInfo from '../views/ProductInfo.vue'
import Basket from '../views/Basket.vue'
import Registration from '../views/Registration.vue'
import login from '../views/login.vue'
import Profile from '../views/Profile.vue'
import ProfileInfo from '../components/layouts/ProfileInfo.vue'
import MyOrders from '../components/layouts/MyOrders.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeView
    },
    {
      path: '/Reviews',
      name: 'Review',
      component: Reviews,
    },
    {
      path: '/Delivery',
      name: 'Delivery',
      component: Delivery,
    },
    {
      path: '/Products',
      name: 'Product',
      component: Product,
    },
    {
      path: '/Products/ProductInfo/:id',
      name: 'ProductInfo',
      component: ProductInfo,
    },
    {
      path: '/Basket',
      name: 'Basket',
      component: Basket,
    },
    {
      path: '/Registration',
      name: 'Registration',
      component: Registration,
    },
    {
      path: '/login',
      name: 'login',
      component: login,
    },
    {
      path: '/Profile',
      name: 'Profile',
      component: Profile,
      children: [
        { path: '/ProfileInfo', component: ProfileInfo },
        { path: '/MyOrders', component: MyOrders },
      ]
    },
  ]
})

export default router
