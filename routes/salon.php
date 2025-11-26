<?php

use App\Http\Controllers\ProviderController;
use App\Http\Controllers\SubdomainControllers\SalonHomeController;
use App\Http\Controllers\SubdomainControllers\SalonTeamController;
use App\Http\Controllers\SubdomainControllers\SalonServiceController;
use App\Http\Controllers\SubdomainControllers\SalonReviewController;
use App\Http\Controllers\SubdomainControllers\SalonContactController;
use App\Http\Controllers\SubdomainControllers\SalonBookingController;
use App\Http\Middleware\CheckSalonStatus;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Salon Subdomain Routes
|--------------------------------------------------------------------------
|
| These routes are loaded for salon subdomains (e.g., newlook.salon.test)
| All routes automatically have the CheckSalonStatus middleware applied
|
*/

Route::domain('{salon}.saloon.test')
    ->middleware(['web', CheckSalonStatus::class])
    ->group(function () {
        // Home/About page
        Route::get('/', [SalonHomeController::class, 'index'])->name('salon.home');

        // Team/Providers pages
        Route::get('/teams', [SalonTeamController::class, 'index'])->name('salon.teams');
        // Route::get('/providers/{provider}', [ProviderController::class, 'show'])->name('providers.show');

        Route::get('/providers/{provider}', [ProviderController::class, 'show'])->name('providers.show');

        // Services page
        Route::get('/services', [SalonServiceController::class, 'index'])->name('salon.services');

        // Reviews pages
        Route::get('/reviews', [SalonReviewController::class, 'index'])->name('salon.reviews');

        // Contact page
        Route::get('/contact', [SalonContactController::class, 'index'])->name('salon.contact');
        Route::post('/contact', [SalonContactController::class, 'submit'])->name('salon.contact.submit');

        // Booking page
        Route::get('/book', [SalonBookingController::class, 'index'])->name('salon.book');
        Route::post('/book', [SalonBookingController::class, 'store'])->name('salon.book.store');
    });
