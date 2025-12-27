<?php

namespace App\Repositories\Announcement;

use App\Models\Announcement;
use Illuminate\Database\Eloquent\Collection;

class AnnouncementRepository implements AnnouncementRepositoryInterface
{
    public function __construct(
        protected Announcement $model
    ) {}

    public function getAll(): Collection
    {
        return $this->model->with('author')->latest()->get();
    }

    public function getById(int $id): ?Announcement
    {
        return $this->model->with('author')->find($id);
    }

    public function create(array $data): Announcement
    {
        $announcement = $this->model->create($data);
        return $announcement->load('author');
    }

    public function update(int $id, array $data): ?Announcement
    {
        $announcement = $this->getById($id);

        if ($announcement) {
            $announcement->update($data);
            return $announcement->fresh('author');
        }

        return null;
    }

    public function delete(int $id): bool
    {
        $announcement = $this->model->find($id);

        if ($announcement) {
            return $announcement->delete();
        }

        return false;
    }
}
