export const baseUrl = "http://127.0.0.1:8000/";    // Экспортируем постоянную api
export const baseUrlApi = baseUrl + "api";          // Экспортируем префикс к нашему api
export const baseUrlStorage = baseUrl + "storage//";    // Экспортируем префикс к апи, где хранятся изображения

const api = {       // Объявляем api
    category: {
        get: baseUrlApi + "/category/get"   // Метод для получения категорий
    },
    reviews: {
        get: baseUrlApi + "/reviews/get"    // Метод для получения отзывов
    },
    product: {
        get: baseUrlApi + "/products/get"   // Метод для получения товаров
    },
    callback: {
        post: baseUrlApi + "/feedback/post"     // Метод отправки формы обратной связи
    },
    order: {
        post: baseUrlApi + "/order/make"        // Метод оформления заказа
    }
}

export default api;     // Экспортируем api
