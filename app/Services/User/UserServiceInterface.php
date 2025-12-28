<?php

namespace App\Services\User;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface UserServiceInterface
{
    public function getAll(): Collection;
    public function create(array $data, User $creator): User;
    public function getCreatableRoles(User $creator): array;
}
