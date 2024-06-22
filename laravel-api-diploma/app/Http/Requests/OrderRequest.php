<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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
            'name' => 'required_without:name|string',
            'phone' => 'required|digits:11',
            'delivery' => 'required|boolean',
            'adress' => 'required_if:delivery,true'
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
            'name.required_without' => '* Укажите ваше имя',
            'phone.required' => '* Укажите ваш телефон',
            'phone.digits' => '* Поле телефон должно содержать 11 цифр',
            'delivery.required' => '* Выберите метод доставки!',
            'adress.required_if' => '* Укажите ваш адрес для доставки'
        ];
    }
}
