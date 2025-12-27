<?php

namespace App\Services\Announcement;

use App\Models\Announcement;
use App\Models\User;
use App\Repositories\Announcement\AnnouncementRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Auth\Access\AuthorizationException;

class AnnouncementService implements AnnouncementServiceInterface
{
    public function __construct(
        protected AnnouncementRepositoryInterface $announcementRepository
    ) {}

    public function getAll(): Collection
    {
        return $this->announcementRepository->getAll();
    }

    public function getById(int $id): ?Announcement
    {
        return $this->announcementRepository->getById($id);
    }

    public function create(array $data, User $user): Announcement
    {
        if ($user->isStudent()) {
            throw new AuthorizationException('Öğrenciler duyuru oluşturamaz.');
        }

        $data['author_id'] = $user->id;

        return $this->announcementRepository->create($data);
    }

    public function update(int $id, array $data, User $user): ?Announcement
    {
        $announcement = $this->announcementRepository->getById($id);

        if (!$announcement) {
            return null;
        }

        if ($user->isStudent()) {
            throw new AuthorizationException('Öğrenciler duyuru düzenleyemez.');
        }

        if ($user->isTeacher() && $announcement->author_id !== $user->id) {
            throw new AuthorizationException('Sadece kendi duyurularınızı düzenleyebilirsiniz.');
        }

        return $this->announcementRepository->update($id, $data);
    }

    public function delete(int $id, User $user): bool
    {
        $announcement = $this->announcementRepository->getById($id);

        if (!$announcement) {
            return false;
        }

        if ($user->isStudent()) {
            throw new AuthorizationException('Öğrenciler duyuru silemez.');
        }

        if ($user->isTeacher() && $announcement->author_id !== $user->id) {
            throw new AuthorizationException('Sadece kendi duyurularınızı silebilirsiniz.');
        }

        return $this->announcementRepository->delete($id);
    }
}
