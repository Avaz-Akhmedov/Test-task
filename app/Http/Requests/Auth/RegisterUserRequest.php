<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterUserRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            'phone' => ['required', 'numeric','','unique:users,phone'],
            'email' => ['required', 'unique:users,email', 'email'],
            'password' => ['required', 'min:6']
        ];
    }
}
