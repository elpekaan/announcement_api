<?php

namespace App\Http\Controllers\Api\Profile;

use App\Http\Controllers\Controller;
use App\Http\Resources\Auth\UserResource;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    use ApiResponse;

    public function show(Request $request): JsonResponse
    {
        return $this->success(
            new UserResource($request->user()),
            'Profil bilgileri'
        );
    }

    public function update(Request $request): JsonResponse
    {
        $user = $request->user();

        $validated = $request->validate([
            'name' => ['sometimes', 'string', 'max:255'],
            'email' => ['sometimes', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id, 'regex:/^[a-zA-Z0-9._%+-]+@ciu\.edu\.tr$/'],
            'current_password' => ['required_with:password', 'string'],
            'password' => ['sometimes', 'nullable', 'string', Password::min(6), 'confirmed'],
            'password_confirmation' => ['sometimes', 'nullable', 'string'],
        ], [
            'name.string' => 'Ad Soyad metin olmalı.',
            'email.email' => 'Geçerli bir email girin.',
            'email.unique' => 'Bu email zaten kayıtlı.',
            'email.regex' => 'Sadece @ciu.edu.tr uzantılı mail adresleri kabul edilmektedir.',
            'current_password.required_with' => 'Şifre değiştirmek için mevcut şifrenizi girin.',
            'password.min' => 'Yeni şifre en az 6 karakter olmalı.',
            'password.confirmed' => 'Şifreler eşleşmiyor.',
        ]);

        if (isset($validated['password']) && !empty($validated['password'])) {
            if (!Hash::check($validated['current_password'], $user->password)) {
                return $this->error('Mevcut şifre hatalı.', 422);
            }
            $user->password = Hash::make($validated['password']);
        }

        if (isset($validated['name'])) {
            $user->name = $validated['name'];
        }

        if (isset($validated['email'])) {
            $user->email = $validated['email'];
        }

        $user->save();

        return $this->success(
            new UserResource($user->fresh()),
            'Profil güncellendi'
        );
    }

    public function destroy(Request $request): JsonResponse
    {
        $user = $request->user();

        $validated = $request->validate([
            'password' => ['required', 'string'],
        ], [
            'password.required' => 'Hesabınızı silmek için şifrenizi girin.',
        ]);

        if (!Hash::check($validated['password'], $user->password)) {
            return $this->error('Şifre hatalı.', 422);
        }

        $user->tokens()->delete();
        $user->delete();

        return $this->success(null, 'Hesabınız silindi');
    }
}
