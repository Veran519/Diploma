<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;

class ReviewController extends Controller
{
    public function getAllReviews() { //Функция получения отзывов покупателей

        try {

            $reviews = Review::query()->get();

            if(!$reviews) {
                return response()->json([
                    'status' => 'Failed',
                    'message' => 'Ни одоного отзыва не было обнаружено!',
                ]);
            }

            return response()->json([
                'reviews' => $reviews,
                'status' => 'success',
                'message' => 'Отзывы получены!',
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'Error',
                'message' => 'Ошибка получения данных с сервера!',
            ]);
        }
    }
}
