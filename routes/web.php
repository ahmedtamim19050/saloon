<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProviderController;
use App\Http\Controllers\SalonController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Public Pages
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::post('/contact', [HomeController::class, 'contactStore'])->name('contact.store');

// Salons
Route::get('/salons', [SalonController::class, 'index'])->name('salons.index');
Route::get('/salons/{salon}', [SalonController::class, 'show'])->name('salons.show');

// Providers
Route::get('/providers/{provider}', [ProviderController::class, 'show'])->name('providers.show');

// Authentication Routes
Auth::routes();

// Authenticated Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/appointments/book/{provider}', [DashboardController::class, 'bookingPage'])->name('appointments.book');
    Route::post('/appointments', [DashboardController::class, 'storeAppointment'])->name('appointments.store');
});
