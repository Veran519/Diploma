<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feedback;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\FeedbackRequest;

class FeedbackController extends Controller
{
    public function askCallBack(FeedbackRequest $req) {

        try {

            $validator = $req->validated(); // Задаем правила и сообщения об ошибках ввода входных данных и получаем проверенные данные
                       
            $tg_user = "5140681251"; //id телеграм бизнес-аккаунта
            $text = "Пользователь ".$validator['name']." требует обратный звонок по номеру: ".$validator['phone']; //переменная, которая хранит шаблон текста, который будет отправлен с присвоением имени и номера телефона с формы обращения на сайте

            file_get_contents("https://api.telegram.org/bot6384176634:AAHloSQvw0LFDxCgAACmEB4kLBh1BxwFBfU/sendMessage?chat_id=$tg_user&text=".$text); //отправка сообщение с помощью бота, используя api телеграм

            return response()->json([
                'text' => $text,
                'status' => 'success',
                'message' => 'Сообщение отправлено!',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => '404',
                'message' => 'Ошибка при отправке сообщения!',
            ]);
        }
        
    }
}
