<?php

namespace App\Services\Announcement;

use App\Models\Announcement;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface AnnouncementServiceInterface
{
    public function getAll(): Collection;
    public function getById(int $id): ?Announcement;
    public function create(array $data, User $user): Announcement;
    public function update(int $id, array $data, User $user): ?Announcement;
    public function delete(int $id, User $user): bool;
}
