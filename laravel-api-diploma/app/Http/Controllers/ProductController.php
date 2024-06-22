<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function getProducts() { // функция получения всех товаров 

        try {

            $products = Product::query()->get(); // получаем все товары из базы и если успешно выводим

            if(!$products) { // если товаров нет то выводим ошибку обнаружения товара
                return response()->json([
                    'status' => 'Error',
                    'message' => 'Товары не найдены!',
                ]);
            }

            return response()->json([
                'products' => $products,
                'status' => 'success',
                'message' => 'Товары получены!',
            ]);
        } catch (\Throwable $th) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Ошибка поиска товаров в БД!!',
                ]);
        }
    }

    public function getProductsById($id) { // функция получения товара по его id

        try {

            $productsById = Product::where('id', $id)->first();

            if(!$productsById) { // Проверка существует ли товар с указанным id 
                return response()->json([
                    'status' => 'Failed',
                    'message' => 'Нет доступных товаров!',
                ]);
            }

            return response()->json([
                'products' => $productsById,
                'status' => 'success',
                'message' => 'Товары получены!',
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'Error',
                'message' => 'Нет доступных товаров!',
            ]);
        } 
    }

    public function getActualandAvailableProducts() { // Функция получения актуальных на текущий момент и доступных(в целом) товаров

        try {
            $actualProducts = DB::table('product')->select('picture', 'isActual', 'isAvailable')->where('isActual', '=', 1)
            ->orwhere('isAvailable', '=', 1)->get(); // выборка тооваров по актуальности и доступности на текущий момент

            if(!$actualProducts) { // Проверка на товары, которые удовлетворяют условиям актуальности и доступности
                return response()->json([
                    'status' => 'Failed',
                    'message' => 'Ни одного товара, удовлетворяющего условию не найдено!',
                ]); 
            }

            return response()->json([
                'product' => $actualProducts,
                'status' => 'success',
                'message' => 'Актуальные и доступные товары получены!',
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'Error',
                'message' => 'Ошибка обнаружения товаров в БД!',
            ]);
        }
    }

    public function getProductInfoByArrayIds(Request $req) { // Функция получения товаров, которые добавили в корзину
        try {
            $arrayids = $req->array_ids; // Получаем id товаров
            $arrayProducts = []; // Создаем пустой массив продуктов, в который позднее попадут товары с id, которые добавляются в корзину
            foreach ($arrayids as $key => $id) { // прогоняем по циклу id товаров, которые выбрал пользователь и далее выбираем среди всех в базе только те, id которых получили
                $product = Product::query()->where('id', $id)->first(); // Ищем товары, с указанными id
                array_push($arrayProducts, $product); // полученные товары складываем в новвый массив
            }

            if(!$arrayProducts) { // Проверка на наличие товаров в массиве
                return response()->json([
                    'status' => 'Failed',
                    'message' => 'Массив пустой или товар отсутствует!',
                ]);
            }

            return response()->json([
                'product' => $arrayProducts,
                'arraids' => $arrayids,
                'status' => 'success',
                'message' => 'Массив товаров обнаружен!',
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                    'status' => 'Error',
                    'message' => 'Ошибка!Нет данных, удовлетворяющих запросу!',
                ]);
        }     
    }
}
