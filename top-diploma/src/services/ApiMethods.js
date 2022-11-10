import points from "./Points";
import $api from "./Config";

export const getCategories = async () => {
    return await $api.get(points.category.get);
} 
