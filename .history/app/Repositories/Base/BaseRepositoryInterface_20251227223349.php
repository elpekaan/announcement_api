<?php

namespace App\Repositories\Base;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

interface BaseRepositoryInterface
{
    public function getAll(): Collection;
    public function getById(int $id): ?Model;
    public function create(array $data): Model;
    public function update(int $id, array $data): ?Model;
    public function delete(int $id): bool;
}
