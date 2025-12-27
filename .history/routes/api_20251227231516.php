<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Announcement\AnnouncementController;

// Public routes
Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
});

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    // Auth
    Route::prefix('auth')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/me', [AuthController::class, 'me']);
    });

    // Announcements
    Route::prefix('announcements')->group(function () {
        Route::get('/', [AnnouncementController::class, 'index']);
        Route::get('/{id}', [AnnouncementController::class, 'show']);
        Route::post('/', [AnnouncementController::class, 'store']);
        Route::put('/{id}', [AnnouncementController::class, 'update']);
        Route::delete('/{id}', [AnnouncementController::class, 'destroy']);
    });
});
