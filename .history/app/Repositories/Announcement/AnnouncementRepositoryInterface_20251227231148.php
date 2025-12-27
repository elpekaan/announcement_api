<?php

namespace App\Repositories\Announcement;

use App\Models\Announcement;
use Illuminate\Database\Eloquent\Collection;

interface AnnouncementRepositoryInterface
{
    public function getAll(): Collection;
    public function getById(int $id): ?Announcement;
    public function create(array $data): Announcement;
    public function update(int $id, array $data): ?Announcement;
    public function delete(int $id): bool;
}
