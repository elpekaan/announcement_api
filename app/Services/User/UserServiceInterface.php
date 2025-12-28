<?php

namespace App\Services\User;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface UserServiceInterface
{
    public function getManageableUsers(User $manager): Collection;
    public function getById(int $id): ?User;
    public function create(array $data, User $creator): User;
    public function update(int $id, array $data, User $editor): ?User;
    public function delete(int $id, User $deleter): bool;
    public function getCreatableRoles(User $creator): array;
}
