<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;

class CategoryController extends Controller
{
    public function getCategoryInfo() {

        return response()->json([
            'categories' => Category::query()->get(),
            'status' => 'success',
            'message' => 'Категории обнаружены',
        ]);
    }

    public function getCategories() {

        $categories = Category::select('category.id', 'category.name')->get();

        foreach ($categories as $category) {
            $category->items = Product::query()->where('category_id', $category->id)->get();
        }

        $res = $categories;
        
        return response()->json([
            'categories' => $res,
            'status' => 'success',
            'message' => 'Категории обнаружены',
        ]);
    }

}