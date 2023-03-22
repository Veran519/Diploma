<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;

class OrderController extends Controller
{
    public function makeOrder(Request $req) {
        $checking = $req->validate([
            'name' => 'required|string',
            'phone' => 'required|string',
            'delivery' => 'required|boolean'
        ]);

        $product_id = $req->product_id;

        $order = Order::query()->create([
            'name'  =>  $req->name,
            'phone' =>  $req->phone,
            'delivery' => $req->delivery,
            'adress' => $req->adress
        ]);

        $order->products()->attach($product_id);

        return response()->json([
            'status' => 'success',
            'message' => 'Заказ сформирован успешно!',
        ]);
    }

    public function makeOrderByUser(Request $req) {
        $credentials = $req->validate([
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

            $name = $req->name;
            $phone = $req->phone;
            $adress = $req->adress;
            $product_id = $req->product_id;
            $user_id = $user->id;

            $order = Order::query()->create([
                'name'  =>  $name,
                'phone' =>  $phone,
                'delivery' => $req->delivery,
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

        return response()->json([
            'order' => $user,
            'status' => 'success',
            'message' => 'Заказы найдены!',
        ]);
    }

    public function getOrder(Request $req) {
        $user = Auth::user();
        $Order = Order::query()->where('user_id', $user->id)
                               ->select('order.id', 'order.name', 'order.phone', 'order.adress', 'order.delivery')
                               ->get();
        
        foreach ($Order as $orders) {
            $orders->products = Order::find($orders->id)->products;
        }

        $res = $Order;

        return response()->json([
            'order' => $res,
            'status' => 'success',
            'message' => 'Заказы найдены!',
        ]);
    }
    
}
