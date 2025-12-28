<?php

namespace App\Repositories\User;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class UserRepository implements UserRepositoryInterface
{
    public function __construct(
        protected User $model
    ) {}

    public function getAll(): Collection
    {
        return $this->model->latest()->get();
    }

    public function getByRoles(array $roles): Collection
    {
        return $this->model->whereIn('role', $roles)->latest()->get();
    }

    public function getById(int $id): ?User
    {
        return $this->model->find($id);
    }

    public function create(array $data): User
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data): ?User
    {
        $user = $this->getById($id);
        
        if (!$user) {
            return null;
        }

        $user->update($data);
        return $user->fresh();
    }

    public function delete(int $id): bool
    {
        $user = $this->getById($id);
        
        if (!$user) {
            return false;
        }

        return $user->delete();
    }
}
