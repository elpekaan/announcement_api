<?php

namespace App\Http\Requests\User;

use App\Enums\UserRole;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\Rules\Password;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $userId = $this->route('id');
        
        return [
            'name' => ['sometimes', 'string', 'max:255'],
            'email' => ['sometimes', 'string', 'email', 'max:255', 'unique:users,email,' . $userId, 'regex:/^[a-zA-Z0-9._%+-]+@ciu\.edu\.tr$/'],
            'password' => ['sometimes', 'nullable', 'string', Password::min(6), 'confirmed'],
            'password_confirmation' => ['sometimes', 'nullable', 'string'],
            'role' => ['sometimes', new Enum(UserRole::class)],
        ];
    }

    public function messages(): array
    {
        return [
            'name.string' => 'Ad Soyad metin olmalı.',
            'email.email' => 'Geçerli bir email girin.',
            'email.unique' => 'Bu email zaten kayıtlı.',
            'email.regex' => 'Sadece @ciu.edu.tr uzantılı mail adresleri kabul edilmektedir.',
            'password.min' => 'Şifre en az 6 karakter olmalı.',
            'password.confirmed' => 'Şifreler eşleşmiyor.',
        ];
    }
}
