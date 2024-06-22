<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // only allow updates if the user is logged in
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|email|unique:App\Models\User,email', 
            'password' => 'required|min:8|confirmed',
            'name' => 'required|string',
            'password_confirmation' => 'required'
        ];
    }

    /**
     * Get the validation attributes that apply to the request.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            //
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'email.required' => 'Поле Email является обязательным!',
            'email.email' => 'Недопустимый формат поля Email!',
            'email.unique' => 'Пользователь с таким Email уже существует!',
            'name.required' => 'Поле Имя является обязательным!',
            'password.required' => 'Поле Пароль является обязательным!',
            'password.confirmed' => 'Пароли не совпадают!',
            'password_confirmation.required' => 'Поле Подтверждение пароля является обязательным!',
        ];
    }
}
