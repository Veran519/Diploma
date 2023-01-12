<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function getProducts() {

        return response()->json([
            'products' => Product::query()->get(),
            'status' => 'success',
            'message' => 'Товары получены!',
        ]);
    }

    public function getProductsById($id) {

        return response()->json([
            'products' => Product::where('id', $id)->get(),
            'status' => 'success',
            'message' => 'Товары получены!',
        ]);
    }

    public function getActualandAvailableProducts() {

        $actualProducts = DB::table('product')->select('picture', 'isActual', 'isAvailable')->where('isActual', '=', 1)
        ->orwhere('isAvailable', '=', 1)->get();

        return response()->json([
            'product' => $actualProducts,
            'status' => 'success',
            'message' => 'Актуальные товары получены!',
        ]);
    }

    public function getProductInfoByArrayIds(Request $req) {
        $arrayids = $req->array_ids;
        $arrayProducts = [];
        foreach ($arrayids as $key => $id) {
            $product = Product::query()->where('id', $id)->first();
            array_push($arrayProducts, $product);
        }

        return response()->json([
            'product' => $arrayProducts,
            'status' => 'success',
            'message' => 'Массив товаров обнаружен!',
        ]);
    }
}
