<?php

namespace App\Http\Requests\Auth;

use App\Enums\UserRole;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', Password::min(6)],
            'role' => ['required', new Enum(UserRole::class)],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Ad Soyad gerekli.',
            'email.required' => 'Email gerekli.',
            'email.email' => 'Geçerli bir email girin.',
            'email.unique' => 'Bu email zaten kayıtlı.',
            'password.required' => 'Şifre gerekli.',
            'password.min' => 'Şifre en az 6 karakter olmalı.',
            'role.required' => 'Kullanıcı tipi gerekli.',
        ];
    }
}
