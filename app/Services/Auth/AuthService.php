<?php

namespace App\Services\Auth;

use App\Models\User;
use App\Repositories\Auth\AuthRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthService implements AuthServiceInterface
{
    public function __construct(
        protected AuthRepositoryInterface $authRepository
    ) {}

    public function register(array $data): array
    {
        $user = $this->authRepository->create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => $data['role'],
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return [
            'user' => $user,
            'token' => $token,
        ];
    }

    public function login(array $credentials): array
    {
        $user = $this->authRepository->findByEmail($credentials['email']);

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Email veya şifre hatalı.'],
            ]);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return [
            'user' => $user,
            'token' => $token,
        ];
    }

    public function logout(User $user): bool
    {
        return $user->currentAccessToken()->delete();
    }

    public function getCurrentUser(User $user): User
    {
        return $user;
    }
}
