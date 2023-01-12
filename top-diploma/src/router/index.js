import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import Reviews from '../views/Reviews.vue'
import Delivery from '../views/Delivery.vue'
import Product from '../views/Product.vue'
import ProductInfo from '../views/ProductInfo.vue'
import Basket from '../views/Basket.vue'

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
  ]
})

export default router
