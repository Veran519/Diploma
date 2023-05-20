<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feedback;
use Illuminate\Support\Facades\Validator;

class FeedbackController extends Controller
{
    public function askCallBack(Request $req) {

        $validator = Validator::make($req->all(), [
            'name' => 'required|string',
            'phone' => 'required|digits:11'
        ]);

        try {
            if ($validator->fails()) {
                $errors = $validator->errors();
                return response()->json([
                    'status' => 'Failed!',
                    'message' => 'Произошла ошибка при заполненнии формы!',
                    'error' => $errors
                ]);
            }
            $validated = $validator->validated();

            Feedback::query()->create([
                'name' => $validated['name'],
                'phone' => $validated['phone'],
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Данные получены!',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'success',
                'message' => 'Данные не найдены!',
            ]);
        }
        
    }
}
