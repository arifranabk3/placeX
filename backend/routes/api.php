<?php

use App\Http\Controllers\Api\V1\AccountController;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\CategoryController;
use App\Http\Controllers\Api\V1\HealthController;
use App\Http\Controllers\Api\V1\ListingController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| PlaceX API Routes (Version 1)
|--------------------------------------------------------------------------
*/

Route::prefix('v1')->group(function () {
    // System Health & Diagnostics
    Route::get('/health', [HealthController::class, 'check']);

    // Public Marketplace Discovery
    Route::get('/categories', [CategoryController::class, 'index']);
    Route::get('/listings', [ListingController::class, 'index']);
    Route::get('/listings/{slug}', [ListingController::class, 'show']);

    // Authentication Endpoints (Rate limited to mitigate credential stuffing)
    Route::prefix('auth')->group(function () {
        Route::post('/register', [AuthController::class, 'register'])->middleware('throttle:10,1');
        Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:10,1');

        Route::middleware('auth:sanctum')->group(function () {
            Route::post('/logout', [AuthController::class, 'logout']);
            Route::get('/me', [AuthController::class, 'me']);
        });
    });

    // Authenticated Account Endpoints
    Route::middleware('auth:sanctum')->prefix('account')->group(function () {
        Route::get('/profile', [AccountController::class, 'profile']);
        Route::patch('/profile', [AccountController::class, 'updateProfile']);
    });
});
