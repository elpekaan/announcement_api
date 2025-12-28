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
use App\Repositories\User\UserRepository;
use App\Repositories\User\UserRepositoryInterface;
use App\Services\User\UserService;
use App\Services\User\UserServiceInterface;

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

        // User
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(UserServiceInterface::class, UserService::class);
    }

    public function boot(): void
    {
        //
    }
}
