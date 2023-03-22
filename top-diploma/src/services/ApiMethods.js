import api from "./config.js";
import axios from "axios";
import baseUrlApi from "./config.js";

const $api = axios.create({
    withCredentials: true,
    baseURL: baseUrlApi
});

export const getCategories = async () => {
    return await $api.get(api.category.get);
} 

export const getAllReviews = async () => {
    return await $api.get(api.reviews.get);
} 

export const getProducts = async () => {
    return await $api.get(api.product.get);
}

export const getProductsById = async (id) => {
    return await $api.get(api.product.get + "/" + id);
}

export const getProductsByCategory = async () => {
    return await $api.get(api.category.get + "categories");
}

export const getActualProducts = async () => {
    return await $api.get(api.product.get + "actual");
}

export const getProductsInBasket = async (array) => {
    return await $api.post(api.product.get + "productsinfo", {
        "array_ids": array
    });
}

export const askCallBack = async (name, phone) => {
    return await $api.post(api.callback.post, name, phone);
}

export const makeOrder = async (name, phone, adress, delivery, product_id) => {
    return await $api.post(api.order.post, name, phone, adress, delivery, product_id);
}
