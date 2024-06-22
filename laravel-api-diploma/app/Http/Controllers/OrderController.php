<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\OrderRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Arr;

class OrderController extends Controller
{
    public function makeOrder(OrderRequest $req) { //Функция формирования заказа для гостевого режима
        
        $validator = $req->validated(); // производим проверку входных данных, если есть ошибки, выбрасываем исключение

        try {
            
            $product_id = $req->product_id; // id продукта в заказе из корзины
            $tg_user = "5140681251"; //id телеграм бизнес-аккаунта
            $photo = Product::where('id', $req->product_id)->first();
            $img = asset('storage/'.$photo->picture);
            $caption = "Букет из заказа";
            
            $order = Order::query()->create([ //формируем заказ через форму на сайте, заполняя нужные поля формы 
                'name'  =>  $validator['name'],
                'phone' =>  $validator['phone'],
                'delivery' => $validator['delivery'],
                'adress' => $req->adress
            ]);
            
            $order->products()->attach($product_id); //добавляем товары к заказу

            $products = Order::with('products')->select('id')->latest()->first();
            $productIds = [];
            foreach ($products->products as $product) {
                $productIds[]= $product->sort;
            }
            $strProdIds = implode(',', $productIds);
            
            if(!$validator['delivery']) {
                $text = "Пользователь ".$validator['name']." с номером телефона: +".$validator['phone']." оставил заказ № ".$products->id." на сайте: Букет № ".$strProdIds." метод доставки: Самовывоз. По адресу: г. Киров, ул. Пр. Строителей, д. 46а";     //переменная, которая хранит шаблон текста, который будет отправлен с присвоением имени и номера телефона с формы обращения на сайте
                $TG = file_get_contents("https://api.telegram.org/bot6384176634:AAHloSQvw0LFDxCgAACmEB4kLBh1BxwFBfU/sendMessage?chat_id=$tg_user&text=".$text); //отправка сообщение с помощью бота, используя api телеграм*/
            } else {
                $text = "Пользователь ".$validator['name']." с номером телефона: +".$validator['phone']." оставил заказ № ".$products->id."на сайте: Букет №".$strProdIds." метод доставки: Доставка по адресу: ".$adr;     //переменная, которая хранит шаблон текста, который будет отправлен с присвоением имени и номера телефона с формы обращения на сайте
                $adr = $req->adress;
                $TG = file_get_contents("https://api.telegram.org/bot6384176634:AAHloSQvw0LFDxCgAACmEB4kLBh1BxwFBfU/sendMessage?chat_id=$tg_user&text=".$text); //отправка сообщение с помощью бота, используя api телеграм*/
            }

            
            /*file_get_contents("https://api.telegram.org/bot6384176634:AAHloSQvw0LFDxCgAACmEB4kLBh1BxwFBfU/sendPhoto?chat_id=$tg_user&photo=".$img); //отправка фото с помощью бота, используя api телеграм*/
            
            return response()->json([
                'order' => $order,
                'status' => 'success',
                'message' => 'Заказ сформирован успешно!'
            ]);

            
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'Error!',
                'message' => 'Ошибка при формировании заказа!',
            ]);
        } 
    }

    public function makeOrderByUser(OrderRequest $req) { //Функция формирования заказа для авторизованного пользователя

        $validator = $req->validated(); // производим проверку входных данных, если есть ошибки, выбрасываем исключение
         
        try {
            
            $user = Auth::user(); //получаем авторизованного пользователя
            $adress = $req->adress; // получаем адрес пользователя из формы
            $product_id = $req->product_id; // извлекаем id товара из корзины
            $user_id = $user->id; // получаем id авторизованного пользователя
            $user_name = $user->name; // получаем имя пользователя из профиля

            $order = Order::query()->create([ //формируем заказ, с помощью заполненных на сайте полей формы и полученных данных из профиля пользоватепля и заполненной формы
                'name'  =>  $user_name,
                'phone' =>  $validator['phone'],
                'delivery' => $validator['delivery'],
                'adress' => $adress,
                'user_id' => $user_id
            ]);

            $order->products()->attach($product_id); // добавляем товары к заказу

            return response()->json([
                'name' => $order,
                'status' => 'success',
                'message' => 'Заказ сформирован успешно!',
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'Failed!',
                'message' => 'Ошибка обращения к БД!',
            ]);
        }
    }

    public function getOrders(Request $req) { // Функция получения заказов авторизованных пользователей
        try {
            $user = Auth::user(); //получаем авторизованного пользователя
            
            $Orders = Order::query()->where('user_id', $user->id)
                               ->select('order.id', 'order.name', 'order.phone', 'order.adress', 'order.delivery')
                               ->get(); //делаем выборку заказов по нужному нам пользователю, выбирая номер заказа, наименование товара, телефон, адрес доставки и метод доставки
        
            foreach ($Orders as $order) { // прогоняем через цикл и присваиваем товар в соответсвтии с заказом
                $order->products;
            }

            $res = $Orders;

            return response()->json([
                'orders' => $res,
                'status' => 'success',
                'message' => 'Заказы найдены!',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'Failed!',
                'message' => 'Ошибка!Заказы не обнаружены!',
            ]);
        }
        
    }
    
}
