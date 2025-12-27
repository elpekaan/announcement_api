<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Auth\AuthRepository;
use App\Repositories\Auth\AuthRepositoryInterface;
use App\Services\Auth\AuthService;
use App\Services\Auth\AuthServiceInterface;
use App\Repositories\Announcement\AnnouncementRepository;
use App\Repositories\Announcement\AnnouncementRepositoryInterface;
use App\Services\Announcement\AnnouncementService;
use App\Services\Announcement\AnnouncementServiceInterface;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Auth
        $this->app->bind(AuthRepositoryInterface::class, AuthRepository::class);
        $this->app->bind(AuthServiceInterface::class, AuthService::class);

        // Announcement
        $this->app->bind(AnnouncementRepositoryInterface::class, AnnouncementRepository::class);
        $this->app->bind(AnnouncementServiceInterface::class, AnnouncementService::class);
    }

    public function boot(): void
    {
        //
    }
}
