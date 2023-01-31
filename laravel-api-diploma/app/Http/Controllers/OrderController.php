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
            'delivery' => 'required|boolean',
            'product_id' => 'required'
        ]);

        $name = $req->name;
        $phone = $req->phone;
        $delivery = $req->delivery;
        $adress = $req->adress;
        $product_id = $req->product_id;
        
        foreach ($product_id as $key => $id) {
            $order = Order::query()->create([
                'name' => $name,
                'adress' => $adress,
                'phone' => $phone,
                'delivery' => $delivery,
                'product_id' => $id
            ]);
        }
        
        $order->products()->attach($product_id);

        return response()->json([
            'status' => 'success',
            'message' => 'Заказ сформирован успешно!',
        ]);
    }

    public function getOrder() {
        $Order= Order::find(26);

        return response()->json([
            'order' => $Order->products()->get(),
            'status' => 'success',
            'message' => 'Заказ сформирован успешно!',
        ]);
    }
}
