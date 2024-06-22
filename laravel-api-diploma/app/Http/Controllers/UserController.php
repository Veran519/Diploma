<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UserRequest;

class UserController extends Controller
{
    public function registerUser(UserRequest $req) // Функция регистрации пользователя
    {
        $validator = $req->validated(); // Получаем отвалидированные данные и сообщения об ошибках из UserReq      

        try{
            $user = User::create([  // Заполняем форму регистрации, отвалидированными данными с помощью validator
                'name' => $validator["name"], 
                'email' => $validator["email"],
                'password' => Hash::make($validator["password"])
            ]);
    
            if($user) { // Если валидация успешна, то создаем нового пользователя и присваиваем ему Токен
                $token = $user->createToken("TokenName");   // Создание токена
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

    public function logout(Request $req) {  //Функция разлогинивая(выхода) пользователя
        $req->user()->currentAccessToken()->delete();   // Получаем текущий токен сессии пользователя, а затем удаляем его, тем самым ралогинив пользователя

        return response()->json([
            'status' => 'succes',
            'message' => 'Вы вышли!',
        ]);
    }

    public function login(Request $req) {   //Функция входа в систему пользователя
        $validator = $req->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ], [                                                            //Создаем правила валидации с помощью validate, а также сообщения об ошибках при вводе данных
            'email.required' => 'Поле Email является обязательным!',
            'password.required' => 'Поле Пароль является обязательным!',
        ]);

        try {
            $user = User::where('email', $validator['email'])->first(); // Ищем пользователя по его логину(email) в базе данных
            if(!$user) {    // Если поиск не успешен, то выводим ошибку
                return response()->json([
                    'status' => '404',
                    'message' => 'Такого пользователя не существует!',
                ]);
            }
            
            if (!Hash::check($req->password, $user->password)) {    // Если пользователь существует, но пароль указан неверно, выводим ошибку
                return response()->json([
                    'status' => '422',
                    'message' => 'Неверный пароль.',
                ]);
            }
            
            $token = $user->createToken("TokenName");   // Создаем новый токен для текущей сессии пользователя
            return response()->json([
                'status' => '202',
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

    public function updateUsersData(Request $req) { //Функция обновления информации о пользователе
        $validator = $req->validate([
            'name' => 'required|string',
            'phone' => 'required|digits_between:6,11',
            'adress' => 'required|string'
        ],                                                          // Создаем правила валидации для воодимых данных, а также сообщения об ошибках ввода
        [
            'name.required' => 'Поле Имя является обязательным!',
            'phone.required' => 'Поле Телефон является обязательным!',
            'adress.required' => 'Поле Адреса является обязательным!',
            'phone.digits_between' => 'Поле Телефон должно содержать количество цифр от 6 до 11!'
        ]);

        try {
            $user = Auth::user();   // Получаем текущего авторизованного пользователя
            
            $user->name = $req->get('name');
            $user->phone = $req->get('phone');      // Вводим новые данные пользователя
            $user->adress = $req->get('adress');
            $user->save();  // Сохраняем новую информацию о пользователе

            return response()->json([
                'info' => $user,
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
