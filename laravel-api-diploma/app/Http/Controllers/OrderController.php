<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;

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

    public function getOrder() {
        $Order= Order::find(31);

        return response()->json([
            'order' => $Order->products()->get(),
            'status' => 'success',
            'message' => 'Заказ сформирован успешно!',
        ]);
    }
}
