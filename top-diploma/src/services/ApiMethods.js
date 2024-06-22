import api from "./config.js";      // Импортируем внешний api из конфифга
import axios from "axios";      // Импорт аксиос
import baseUrlApi from "./config.js";   // Импортируем префикс api

const $api = axios.create({     // Объявляем постоянную переменную api
    withCredentials: true,
    baseURL: baseUrlApi
});

export const getCategories = async () => {      // Экспортируем функцию получения категорий с api
    return await $api.get(api.category.get);
} 

export const getAllReviews = async () => {      // Экспортируем функцию получения всех отзывов с api
    return await $api.get(api.reviews.get);
} 

export const getProducts = async () => {        // Экспортируем функцию получения товаров с api
    return await $api.get(api.product.get);
}

export const getProductsById = async (id) => {      // Экспортируем функцию получения товаров по его id с api
    return await $api.get(api.product.get + "/" + id);
}

export const getProductsByCategory = async () => {      // Экспортируем функцию получения товаров по категориям с api
    return await $api.get(api.category.get + "categories");
}

export const getActualProducts = async () => {          // Экспортируем функцию получения актуальных товаров для слайдера с api
    return await $api.get(api.product.get + "actual");
}

export const getProductsInBasket = async (array) => {       // Экспортируем функцию получения товаров, которые находятся в корзине
    return await $api.post(api.product.get + "productsinfo", {
        "array_ids": array
    });
}

export const askCallBack = async (name, phone) => {         // Экспортируем функцию запроса обратной связи на api
    return await $api.post(api.callback.post, name, phone);
}

export const makeOrder = async (name, phone, adress, delivery, product_id) => {     // Экспортируем функцию оформления заказа на api
    return await $api.post(api.order.post, name, phone, adress, delivery, product_id);
}
