<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginUserRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'email' => ['required', 'email', 'exists:users,email'],
            'password' => ['required']
        ];
    }

    /**
     * @throws ValidationException
     */
    public function validate()
    {
        if (!Auth::attempt($this->only('email', 'password'))) {
            throw ValidationException::withMessages([
                'email' => __('auth.failed')
            ]);
        }
    }

}
