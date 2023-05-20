<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function makeOrder(Request $req) {
        $validator = Validator::make($req->all(), [
            'name' => 'required|string',
            'phone' => 'required|string',
            'delivery' => 'required|boolean'
        ]);

        try {
            if ($validator->fails()) {
                $errors = $validator->errors();
                return response()->json([
                    'status' => 'Failed!',
                    'message' => 'Произошла ошибка заполнения формы!',
                    'error' => $errors
                ]);
            }
            $validated = $validator->validated();
            $product_id = $req->product_id;

            $order = Order::query()->create([
                'name'  =>  $validated['name'],
                'phone' =>  $validated['phone'],
                'delivery' => $validated['delivery'],
                'adress' => $req->adress
            ]);

            $order->products()->attach($product_id);
            
            return response()->json([
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

    public function makeOrderByUser(Request $req) {
        $validator = Validator::make($req->all(), [
            'name' => 'string',
            'phone' => 'digits:11',
            'delivery' => 'required|boolean'
        ],
        [
            'name.string' => 'Поле Имя является обязательным!',
            'phone.digits' => 'Поле Телефон является обязательным!',
            'delivery.required' => 'Выберите метод доставки!'
        ]);

        try {
            $user = Auth::user();

            if ($validator->fails()) {
                $errors = $validator->errors();
                return response()->json([
                    'status' => 'Failed!',
                    'message' => 'Произошла ошибка заполнения данных формы!',
                    'error' => $errors
                ]);
            }
            $validated = $validator->validated();

            $adress = $req->adress;
            $product_id = $req->product_id;
            $user_id = $user->id;

            $order = Order::query()->create([
                'name'  =>  $validated['name'],
                'phone' =>  $validated['phone'],
                'delivery' => $validated['delivery'],
                'adress' => $adress,
                'user_id' => $user_id
            ]);

            $order->products()->attach($product_id);

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

    public function getOrders(Request $req) {
        try {
            $user = Auth::user();
            
            $Orders = Order::query()->where('user_id', $user->id)
                               ->select('order.id', 'order.name', 'order.phone', 'order.adress', 'order.delivery')
                               ->get();
        
            foreach ($Orders as $order) {
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
