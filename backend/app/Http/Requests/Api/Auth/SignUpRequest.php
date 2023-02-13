<?php

namespace App\Http\Requests\Api\Auth;

use Illuminate\Foundation\Http\FormRequest;

class SignUpRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name'=> 'required|string|min:3',
            'email'=> 'required|email|unique:users,email',
            'password'=> 'required|string|min:6|confirmed',
        ];
    }
}
