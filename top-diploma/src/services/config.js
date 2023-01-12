export const baseUrl = "http://127.0.0.1:8000/";
export const baseUrlApi = baseUrl + "api";
export const baseUrlStorage = baseUrl + "storage//";

const api = {
    category: {
        get: baseUrlApi + "/category/get"
    },
    reviews: {
        get: baseUrlApi + "/reviews/get"
    },
    product: {
        get: baseUrlApi + "/products/get"
    },
    callback: {
        post: baseUrlApi + "/feedback/post"
    },
    order: {
        post: baseUrlApi + "/order/make"
    }
}

export default api;
