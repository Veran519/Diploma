<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;

class ReviewController extends Controller
{
    public function getAllReviews() {

        return response()->json([
            'reviews' => Review::query()->get(),
            'status' => 'success',
            'message' => 'Изображения получены!',
        ]);
    }
}
