<?php

namespace App\Services\User;

use App\Enums\UserRole;
use App\Models\User;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Hash;

class UserService implements UserServiceInterface
{
    public function __construct(
        protected UserRepositoryInterface $userRepository
    ) {}

    public function getAll(): Collection
    {
        return $this->userRepository->getAll();
    }

    public function create(array $data, User $creator): User
    {
        if (!$creator->canCreateUsers()) {
            throw new AuthorizationException('Kullanıcı oluşturma yetkiniz yok.');
        }

        $requestedRole = UserRole::from($data['role']);
        $allowedRoles = $this->getCreatableRoles($creator);

        if (!in_array($requestedRole, $allowedRoles)) {
            throw new AuthorizationException('Bu rolde kullanıcı oluşturma yetkiniz yok.');
        }

        return $this->userRepository->create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => $data['role'],
        ]);
    }

    public function getCreatableRoles(User $creator): array
    {
        if ($creator->isSuperAdmin()) {
            return UserRole::superAdminCreatableRoles();
        }

        if ($creator->isAdmin()) {
            return UserRole::adminCreatableRoles();
        }

        return [];
    }
}
