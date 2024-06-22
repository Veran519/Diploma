<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;

class CategoryController extends Controller
{
    public function getCategoryInfo() {

        try {
            $categories = Category::query()->get(); //Получаем всем категории из базы

            return response()->json([
                'categories' => $categories,
                'status' => 'success',
                'message' => 'Категории обнаружены',
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'Error!',
                'message' => 'Ошибка обращения к базе. Категории не найдены.',
            ]);
        }

        
    }

    public function getCategories() {

        try {
            $categories = Category::select('category.id', 'category.name')->get(); // Выбираем id и имя категории из базы

            foreach ($categories as $category) {
                $category->items = Product::query()->where('category_id', $category->id)->get(); //Проходим циклом по категориям и добавляем к каждой продукты, которые соответствуют запрашиваемой категории
            }

            $res = $categories; // записываем полученные результаты товаров по категориям в новую переменную
            
            return response()->json([
                'categories' => $res,
                'status' => 'success',
                'message' => 'Категории обнаружены',
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'Error',
                'message' => 'Нет подобных категорий.',
            ]);
        }
    }

}