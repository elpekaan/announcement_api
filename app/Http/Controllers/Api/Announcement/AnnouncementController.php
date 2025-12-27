<?php

namespace App\Http\Controllers\Api\Announcement;

use App\Http\Controllers\Controller;
use App\Http\Requests\Announcement\StoreAnnouncementRequest;
use App\Http\Requests\Announcement\UpdateAnnouncementRequest;
use App\Http\Resources\Announcement\AnnouncementResource;
use App\Services\Announcement\AnnouncementServiceInterface;
use App\Traits\ApiResponse;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    use ApiResponse;

    public function __construct(
        protected AnnouncementServiceInterface $announcementService
    ) {}

    public function index(): JsonResponse
    {
        $announcements = $this->announcementService->getAll();

        return $this->success(
            AnnouncementResource::collection($announcements),
            'Duyurular listelendi'
        );
    }

    public function show(int $id): JsonResponse
    {
        $announcement = $this->announcementService->getById($id);

        if (!$announcement) {
            return $this->error('Duyuru bulunamadı', 404);
        }

        return $this->success(
            new AnnouncementResource($announcement),
            'Duyuru detayı'
        );
    }

    public function store(StoreAnnouncementRequest $request): JsonResponse
    {
        try {
            $announcement = $this->announcementService->create(
                $request->validated(),
                $request->user()
            );

            return $this->success(
                new AnnouncementResource($announcement),
                'Duyuru oluşturuldu',
                201
            );
        } catch (AuthorizationException $e) {
            return $this->error($e->getMessage(), 403);
        }
    }

    public function update(UpdateAnnouncementRequest $request, int $id): JsonResponse
    {
        try {
            $announcement = $this->announcementService->update(
                $id,
                $request->validated(),
                $request->user()
            );

            if (!$announcement) {
                return $this->error('Duyuru bulunamadı', 404);
            }

            return $this->success(
                new AnnouncementResource($announcement),
                'Duyuru güncellendi'
            );
        } catch (AuthorizationException $e) {
            return $this->error($e->getMessage(), 403);
        }
    }

    public function destroy(Request $request, int $id): JsonResponse
    {
        try {
            $deleted = $this->announcementService->delete($id, $request->user());

            if (!$deleted) {
                return $this->error('Duyuru bulunamadı', 404);
            }

            return $this->success(null, 'Duyuru silindi');
        } catch (AuthorizationException $e) {
            return $this->error($e->getMessage(), 403);
        }
    }
}
