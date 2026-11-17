<?php

use App\Http\Controllers\PortalAdmin\Auth\PortalAuthController;
use App\Http\Controllers\PortalAdmin\PortalCategoryController;
use App\Http\Controllers\PortalAdmin\PortalDashboardController;
use App\Http\Controllers\PortalAdmin\PortalEnquiryController;
use App\Http\Controllers\PortalAdmin\PortalHomepageController;
use App\Http\Controllers\PortalAdmin\PortalListingController;
use App\Http\Controllers\PortalAdmin\PortalMediaController;
use App\Http\Controllers\PortalAdmin\PortalSeoController;
use App\Http\Controllers\PortalAdmin\PortalVerticalController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| PlaceX Portal Admin Routes
|--------------------------------------------------------------------------
| Dedicated marketplace CMS for Next.js frontend curation.
| Distinct from the Super Admin Panel at /admin.
*/

// Portal Admin Guest Authentication
Route::prefix('portal-admin')->name('portal-admin.')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('/login', [PortalAuthController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [PortalAuthController::class, 'login'])->name('login.submit');
    });
});

// Portal Admin Authenticated & Authorized Routes
Route::prefix('portal-admin')->name('portal-admin.')->middleware(['web', 'portal.auth'])->group(function () {
    Route::post('/logout', [PortalAuthController::class, 'logout'])->name('logout');

    // Dashboard
    Route::get('/', function () {
        return redirect()->route('portal-admin.dashboard');
    });
    Route::get('/dashboard', [PortalDashboardController::class, 'index'])->name('dashboard');

    // Marketplace Listings Management
    Route::get('/listings', [PortalListingController::class, 'index'])->name('listings.index');
    Route::get('/listings/create', [PortalListingController::class, 'create'])->name('listings.create');
    Route::post('/listings', [PortalListingController::class, 'store'])->name('listings.store');
    Route::get('/listings/{listing}/edit', [PortalListingController::class, 'edit'])->name('listings.edit');
    Route::put('/listings/{listing}', [PortalListingController::class, 'update'])->name('listings.update');
    Route::patch('/listings/{listing}/publish', [PortalListingController::class, 'publish'])->name('listings.publish');
    Route::patch('/listings/{listing}/unpublish', [PortalListingController::class, 'unpublish'])->name('listings.unpublish');
    Route::patch('/listings/{listing}/pause', [PortalListingController::class, 'pause'])->name('listings.pause');
    Route::delete('/listings/{listing}', [PortalListingController::class, 'destroy'])->name('listings.destroy');

    // Core Marketplace 5 Verticals (Jobs, Property, Classifieds, Vehicles, Matrimonial)
    Route::prefix('jobs')->name('jobs.')->group(function () {
        Route::get('/', [PortalVerticalController::class, 'index'])->defaults('vertical', 'jobs')->name('index');
        Route::get('/create', [PortalVerticalController::class, 'create'])->defaults('vertical', 'jobs')->name('create');
        Route::post('/', [PortalVerticalController::class, 'store'])->defaults('vertical', 'jobs')->name('store');
    });

    Route::prefix('property')->name('property.')->group(function () {
        Route::get('/', [PortalVerticalController::class, 'index'])->defaults('vertical', 'property')->name('index');
        Route::get('/create', [PortalVerticalController::class, 'create'])->defaults('vertical', 'property')->name('create');
        Route::post('/', [PortalVerticalController::class, 'store'])->defaults('vertical', 'property')->name('store');
    });

    Route::prefix('classifieds')->name('classifieds.')->group(function () {
        Route::get('/', [PortalVerticalController::class, 'index'])->defaults('vertical', 'classifieds')->name('index');
        Route::get('/create', [PortalVerticalController::class, 'create'])->defaults('vertical', 'classifieds')->name('create');
        Route::post('/', [PortalVerticalController::class, 'store'])->defaults('vertical', 'classifieds')->name('store');
    });

    Route::prefix('vehicles')->name('vehicles.')->group(function () {
        Route::get('/', [PortalVerticalController::class, 'index'])->defaults('vertical', 'vehicles')->name('index');
        Route::get('/create', [PortalVerticalController::class, 'create'])->defaults('vertical', 'vehicles')->name('create');
        Route::post('/', [PortalVerticalController::class, 'store'])->defaults('vertical', 'vehicles')->name('store');
    });

    Route::prefix('matrimonial')->name('matrimonial.')->group(function () {
        Route::get('/', [PortalVerticalController::class, 'index'])->defaults('vertical', 'matrimonial')->name('index');
        Route::get('/create', [PortalVerticalController::class, 'create'])->defaults('vertical', 'matrimonial')->name('create');
        Route::post('/', [PortalVerticalController::class, 'store'])->defaults('vertical', 'matrimonial')->name('store');
    });

    // Homepage Content Management
    Route::get('/homepage', [PortalHomepageController::class, 'index'])->name('homepage.index');
    Route::put('/homepage', [PortalHomepageController::class, 'update'])->name('homepage.update');

    // Media Library
    Route::get('/media', [PortalMediaController::class, 'index'])->name('media.index');
    Route::post('/media/upload', [PortalMediaController::class, 'upload'])->name('media.upload');
    Route::delete('/media/{image}', [PortalMediaController::class, 'destroy'])->name('media.destroy');

    // Categories Taxonomy
    Route::get('/categories', [PortalCategoryController::class, 'index'])->name('categories.index');
    Route::post('/categories', [PortalCategoryController::class, 'store'])->name('categories.store');

    // SEO Management
    Route::get('/seo', [PortalSeoController::class, 'index'])->name('seo.index');
    Route::put('/seo', [PortalSeoController::class, 'update'])->name('seo.update');

    // Enquiries & Complaints
    Route::get('/enquiries', [PortalEnquiryController::class, 'index'])->name('enquiries.index');
    Route::get('/enquiries/{enquiry}', [PortalEnquiryController::class, 'show'])->name('enquiries.show');
    Route::patch('/enquiries/{enquiry}', [PortalEnquiryController::class, 'update'])->name('enquiries.update');
});
