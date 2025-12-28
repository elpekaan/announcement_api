<?php

namespace App\Services\User;

use App\Enums\UserRole;
use App\Models\User;
use App\Policies\UserPolicy;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Hash;

class UserService implements UserServiceInterface
{
    public function __construct(
        protected UserRepositoryInterface $userRepository,
        protected UserPolicy $userPolicy
    ) {}

    public function getManageableUsers(User $manager): Collection
    {
        $manageableRoles = $this->userPolicy->getManageableRoles($manager);
        
        if (empty($manageableRoles)) {
            return new Collection();
        }

        $roleValues = array_map(fn($role) => $role->value, $manageableRoles);
        
        return $this->userRepository->getByRoles($roleValues);
    }

    public function getById(int $id): ?User
    {
        return $this->userRepository->getById($id);
    }

    public function create(array $data, User $creator): User
    {
        if (!$this->userPolicy->create($creator)) {
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

    public function update(int $id, array $data, User $editor): ?User
    {
        $user = $this->userRepository->getById($id);
        
        if (!$user) {
            return null;
        }

        if (!$this->userPolicy->update($editor, $user)) {
            throw new AuthorizationException('Bu kullanıcıyı düzenleme yetkiniz yok.');
        }

        if (isset($data['role'])) {
            $requestedRole = UserRole::from($data['role']);
            $allowedRoles = $this->getCreatableRoles($editor);

            if (!in_array($requestedRole, $allowedRoles)) {
                throw new AuthorizationException('Bu role atama yetkiniz yok.');
            }
        }

        $updateData = [];
        
        if (isset($data['name'])) {
            $updateData['name'] = $data['name'];
        }
        
        if (isset($data['email'])) {
            $updateData['email'] = $data['email'];
        }
        
        if (isset($data['password']) && !empty($data['password'])) {
            $updateData['password'] = Hash::make($data['password']);
        }
        
        if (isset($data['role'])) {
            $updateData['role'] = $data['role'];
        }

        return $this->userRepository->update($id, $updateData);
    }

    public function delete(int $id, User $deleter): bool
    {
        $user = $this->userRepository->getById($id);
        
        if (!$user) {
            return false;
        }

        if (!$this->userPolicy->delete($deleter, $user)) {
            throw new AuthorizationException('Bu kullanıcıyı silme yetkiniz yok.');
        }

        return $this->userRepository->delete($id);
    }

    public function getCreatableRoles(User $creator): array
    {
        return $this->userPolicy->getManageableRoles($creator);
    }
}
