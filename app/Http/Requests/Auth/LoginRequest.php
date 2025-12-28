<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email', ], // 'regex:/^[a-zA-Z0-9._%+-]+@ciu\.edu\.tr$/'
            'password' => ['required', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'Email gerekli.',
            'email.email' => 'Geçerli bir email girin.',
            // 'email.regex' => 'Sadece @ciu.edu.tr uzantılı mail adresleri ile giriş yapabilirsiniz.',
            'password.required' => 'Şifre gerekli.',
        ];
    }
}
