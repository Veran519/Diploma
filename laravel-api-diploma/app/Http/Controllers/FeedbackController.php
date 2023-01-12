<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feedback;

class FeedbackController extends Controller
{
    public function askCallBack(Request $req) {

        $checking = $req->validate([
            'name' => 'required|string',
            'phone' => 'required|string'
        ]);

        $name = $req->name;
        $phone = $req->phone;

        Feedback::query()->create([
            'name' => $name,
            'phone' => $phone,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Данные получены!',
        ]);
    }
}
