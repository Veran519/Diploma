<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function registerUser(Request $req) 
    {
        $credentials = $req->validate([
            'email' => 'required|email|unique:App\Models\User,email',
            'password' => 'required|min:8',
            'name' => 'required|string',
            'password_confirm' => 'required'
        ],
        [
            'email.required' => 'Поле Email является обязательным!',
            'email.email' => 'Недопустимый формат поля Email!',
            'email.unique' => 'Пользователь с таким Email уже существует!',
            'name.required' => 'Поле Имя является обязательным!',
            'password.required' => 'Поле Пароль является обязательным!',
            'password.confirmed' => 'Пароли не совпадают!',
            'password_confirm.required' => 'Поле Подтверждение пароля является обязательным!',
        ]);        

        try{
            $user = User::create([
                'name' => $credentials["name"], 
                'email' => $credentials["email"],
                'password' => Hash::make($credentials["password"])
            ]);
    
            if($user) {
                $token = $user->createToken("TokenName");
                return response()->json([
                    'status' => 'success',
                    'message' => 'Новый пользователь успешно создан!',
                    'token' => $token->plainTextToken
                ]);
            }  
            return response()->json([
                'status' => 'error',
                'message' => 'Упс, что-то пошло не так!',
            ]);
        }catch(\Exception $e){
            return response()->json([
                'status' => 'error BD',
                'message' => 'Ошибка базы данных!',
            ]);
        }
    }

    public function logout(Request $req) {
        $req->user()->currentAccessToken()->delete();

        return response()->json([
            'status' => 'succes',
            'message' => 'Вы вышли!',
        ]);
    }

    public function login(Request $req) {
        $credentials = $req->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ], [
            'email.required' => 'Поле Email является обязательным!',
            'password.required' => 'Поле Пароль является обязательным!',
        ]);
        try {
            $user = User::where('email', $credentials['email'])->first();
            if(!$user) {
                return response()->json([
                    'status' => 'Not Found',
                    'message' => 'Такого пользователя не существует!',
                ]);
            }
            
            if (!Hash::check($req->password, $user->password)) {
                return response()->json([
                    'status' => 'wrong password',
                    'message' => 'Неверный пароль.',
                ]);
            }
            
            $token = $user->createToken("TokenName");
            return response()->json([
                'status' => 'succes',
                'message' => 'Вы вошли!',
                'token' => $token->plainTextToken,
            ]);
        } catch(\Exception $e){
            return response()->json([
                'status' => 'error BD',
                'message' => 'Ошибка базы данных!',
            ]);
        }
    }

    public function updateUsersData(Request $req) {
        $credentials = $req->validate([
            'name' => 'required|string',
            'phone' => 'required|digits:11',
            'adress' => 'required|string'
        ],
        [
            'name.required' => 'Поле Имя является обязательным!',
            'phone.required' => 'Поле Телефон является обязательным!',
            'adress.required' => 'Поле Адреса является обязательным!',
        ]);

        try {
            $user = Auth::user();
            
            $user->name = $req->get('name');
            $user->phone = $req->get('phone');
            $user->adress = $req->get('adress');
            $user->save();

            return response()->json([
                'status' => 'Success',
                'message' => 'Данные успешно обновлены!',
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error BD',
                'message' => 'Ошибка обновления базы данных!',
            ]);
        }
    }
}
