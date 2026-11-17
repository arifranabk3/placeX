<?php

use App\Http\Controllers\Admin\AuditLogController;
use App\Http\Controllers\Admin\Auth\AdminAuthController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ListingController;
use App\Http\Controllers\Admin\ModerationController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\PromotionController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SellerController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect('/admin/login');
});

// Admin Guest Routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [AdminAuthController::class, 'login'])->name('login.submit');
        Route::get('/forgot-password', [AdminAuthController::class, 'showForgotPasswordForm'])->name('password.request');
        Route::post('/forgot-password', [AdminAuthController::class, 'sendResetLinkEmail'])->name('password.email');
        Route::get('/reset-password/{token}', [AdminAuthController::class, 'showResetPasswordForm'])->name('password.reset');
        Route::post('/reset-password', [AdminAuthController::class, 'resetPassword'])->name('password.update');
    });
});

// Admin Authenticated & Authorized Routes
Route::prefix('admin')->name('admin.')->middleware(['web', 'admin.auth'])->group(function () {
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Users Management
    Route::middleware('admin.permission:users.view')->group(function () {
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
    });
    Route::middleware('admin.permission:users.edit')->group(function () {
        Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
        Route::patch('/users/{user}/status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');
    });
    Route::delete('/users/{user}', [UserController::class, 'destroy'])
        ->middleware('admin.permission:users.delete')
        ->name('users.destroy');

    // Sellers Management
    Route::middleware('admin.permission:sellers.view')->group(function () {
        Route::get('/sellers', [SellerController::class, 'index'])->name('sellers.index');
        Route::get('/sellers/{seller}', [SellerController::class, 'show'])->name('sellers.show');
    });
    Route::middleware('admin.permission:sellers.manage')->group(function () {
        Route::patch('/sellers/{seller}/verify', [SellerController::class, 'toggleVerification'])->name('sellers.toggle-verify');
        Route::patch('/sellers/{seller}/suspend', [SellerController::class, 'toggleSuspension'])->name('sellers.toggle-suspend');
    });

    // Listings Management
    Route::middleware('admin.permission:listings.view')->group(function () {
        Route::get('/listings', [ListingController::class, 'index'])->name('listings.index');
        Route::get('/listings/{listing}', [ListingController::class, 'show'])->name('listings.show');
    });
    Route::middleware('admin.permission:listings.edit')->group(function () {
        Route::get('/listings/{listing}/edit', [ListingController::class, 'edit'])->name('listings.edit');
        Route::put('/listings/{listing}', [ListingController::class, 'update'])->name('listings.update');
        Route::patch('/listings/{listing}/moderation', [ListingController::class, 'updateModeration'])->name('listings.update-moderation');
    });
    Route::delete('/listings/{listing}', [ListingController::class, 'destroy'])
        ->middleware('admin.permission:listings.delete')
        ->name('listings.destroy');

    // Categories
    Route::middleware('admin.permission:categories.manage')->group(function () {
        Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
        Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
        Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
        Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
    });

    // Moderation Queue
    Route::middleware('admin.permission:moderation.queue')->group(function () {
        Route::get('/moderation', [ModerationController::class, 'index'])->name('moderation.index');
        Route::post('/moderation/{listing}', [ModerationController::class, 'process'])->name('moderation.process');
    });

    // Reports & Complaints
    Route::middleware('admin.permission:reports.manage')->group(function () {
        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('/reports/{report}', [ReportController::class, 'show'])->name('reports.show');
        Route::patch('/reports/{report}', [ReportController::class, 'update'])->name('reports.update');
    });

    // Promotions
    Route::middleware('admin.permission:promotions.manage')->group(function () {
        Route::get('/promotions', [PromotionController::class, 'index'])->name('promotions.index');
        Route::post('/promotions/entitlement', [PromotionController::class, 'grantEntitlement'])->name('promotions.grant');
    });

    // Payments
    Route::middleware('admin.permission:payments.view')->group(function () {
        Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index');
        Route::patch('/payments/{payment}', [PaymentController::class, 'updateStatus'])->name('payments.update-status');
    });

    // Roles & Permissions (Super Admin only)
    Route::middleware('admin.permission:roles.manage')->group(function () {
        Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
        Route::put('/roles/{role}/permissions', [RoleController::class, 'updatePermissions'])->name('roles.update-permissions');
    });

    // Notifications
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/mark-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.mark-read');

    // Audit Logs
    Route::get('/audit-logs', [AuditLogController::class, 'index'])
        ->middleware('admin.permission:audit.view')
        ->name('audit-logs.index');

    // Settings
    Route::middleware('admin.permission:settings.manage')->group(function () {
        Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
        Route::put('/settings', [SettingController::class, 'update'])->name('settings.update');
    });
});
