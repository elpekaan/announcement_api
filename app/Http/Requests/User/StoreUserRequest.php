<?php

namespace App\Http\Requests\User;

use App\Enums\UserRole;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\Rules\Password;

class StoreUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users', 'regex:/^[a-zA-Z0-9._%+-]+@ciu\.edu\.tr$/'],
            'password' => ['required', 'string', Password::min(6), 'confirmed'],
            'password_confirmation' => ['required', 'string'],
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
            'email.regex' => 'Sadece @ciu.edu.tr uzantılı mail adresleri kabul edilmektedir.',
            'password.required' => 'Şifre gerekli.',
            'password.min' => 'Şifre en az 6 karakter olmalı.',
            'password.confirmed' => 'Şifreler eşleşmiyor.',
            'password_confirmation.required' => 'Şifre tekrarı gerekli.',
            'role.required' => 'Kullanıcı tipi gerekli.',
        ];
    }
}
