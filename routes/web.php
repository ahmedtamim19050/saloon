<?php

use App\Http\Controllers\Auth\SalonRegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProviderController;
use App\Http\Controllers\SalonController;
use App\Http\Controllers\ServiceController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Public Pages
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::post('/contact', [HomeController::class, 'contactStore'])->name('contact.store');

// Salon Registration
Route::get('/salon/register', [SalonRegisterController::class, 'showRegistrationForm'])->name('salon.register');
Route::post('/salon/register', [SalonRegisterController::class, 'register'])->name('salon.register.submit');

// Services
Route::get('/services', [ServiceController::class, 'index'])->name('services.index');

// Salons
Route::get('/salons', [SalonController::class, 'index'])->name('salons.index');
Route::get('/salons/{salon}', [SalonController::class, 'show'])->name('salons.show');

// Providers
Route::get('/providers', [ProviderController::class, 'index'])->name('providers.index');
Route::get('/providers/{provider}', [ProviderController::class, 'show'])->name('providers.show');

// Authentication Routes
Auth::routes();

// Salon Dashboard Routes
Route::middleware(['auth', 'role:salon'])->prefix('salon-dashboard')->name('salon.')->group(function () {
    Route::get('/', [App\Http\Controllers\Salon\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/providers', [App\Http\Controllers\Salon\DashboardController::class, 'providers'])->name('providers');
    Route::get('/providers/{provider}', [App\Http\Controllers\Salon\DashboardController::class, 'providerView'])->name('provider.view');
    Route::get('/bookings', [App\Http\Controllers\Salon\DashboardController::class, 'bookings'])->name('bookings');
    Route::get('/earnings', [App\Http\Controllers\Salon\DashboardController::class, 'earnings'])->name('earnings');
    Route::get('/profile', [App\Http\Controllers\Salon\DashboardController::class, 'profile'])->name('profile');
    Route::post('/profile', [App\Http\Controllers\Salon\DashboardController::class, 'updateProfile'])->name('profile.update');
    Route::get('/settings', [App\Http\Controllers\Salon\DashboardController::class, 'settings'])->name('settings');
    Route::post('/settings', [App\Http\Controllers\Salon\DashboardController::class, 'updateSettings'])->name('settings.update');
});

// Provider Dashboard Routes
Route::middleware(['auth', 'role:provider'])->prefix('provider-dashboard')->name('provider.')->group(function () {
    Route::get('/', [App\Http\Controllers\Provider\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/bookings', [App\Http\Controllers\Provider\DashboardController::class, 'bookings'])->name('bookings.index');
    Route::post('/bookings/{appointment}/status', [App\Http\Controllers\Provider\DashboardController::class, 'updateStatus'])->name('bookings.update-status');
    Route::get('/wallet', [App\Http\Controllers\Provider\DashboardController::class, 'wallet'])->name('wallet.index');
    Route::get('/reviews', [App\Http\Controllers\Provider\DashboardController::class, 'reviews'])->name('reviews.index');
    Route::get('/profile', [App\Http\Controllers\Provider\DashboardController::class, 'profile'])->name('profile');
    Route::put('/profile', [App\Http\Controllers\Provider\DashboardController::class, 'updateProfile'])->name('profile.update');
    Route::get('/settings', [App\Http\Controllers\Provider\DashboardController::class, 'settings'])->name('settings');
    Route::put('/settings', [App\Http\Controllers\Provider\DashboardController::class, 'updateSettings'])->name('settings.update');
    Route::put('/settings/notifications', [App\Http\Controllers\Provider\DashboardController::class, 'updateNotifications'])->name('settings.notifications');
});

// Customer Dashboard Routes
Route::middleware(['auth', 'role:customer'])->prefix('customer-dashboard')->name('customer.')->group(function () {
    Route::get('/', [App\Http\Controllers\Customer\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/bookings', [App\Http\Controllers\Customer\DashboardController::class, 'bookings'])->name('bookings');
    Route::get('/payments', [App\Http\Controllers\Customer\DashboardController::class, 'payments'])->name('payments');
    Route::get('/payment/{appointment}', [App\Http\Controllers\Customer\DashboardController::class, 'payment'])->name('payment');
    Route::post('/payment/{appointment}', [App\Http\Controllers\Customer\DashboardController::class, 'processPayment'])->name('payment.process');
    Route::get('/review/{appointment}', [App\Http\Controllers\Customer\DashboardController::class, 'review'])->name('review');
    Route::post('/review/{appointment}', [App\Http\Controllers\Customer\DashboardController::class, 'storeReview'])->name('review.store');
    Route::get('/profile', [App\Http\Controllers\Customer\DashboardController::class, 'profile'])->name('profile');
    Route::get('/settings', [App\Http\Controllers\Customer\DashboardController::class, 'settings'])->name('settings');
    Route::put('/settings', [App\Http\Controllers\Customer\DashboardController::class, 'updateSettings'])->name('settings.update');
    Route::put('/password', [App\Http\Controllers\Customer\DashboardController::class, 'updatePassword'])->name('password.update');
    Route::put('/notifications', [App\Http\Controllers\Customer\DashboardController::class, 'updateNotifications'])->name('notifications.update');
    Route::put('/privacy', [App\Http\Controllers\Customer\DashboardController::class, 'updatePrivacy'])->name('privacy.update');
    Route::delete('/account', [App\Http\Controllers\Customer\DashboardController::class, 'deleteAccount'])->name('account.delete');
});

// Legacy dashboard route (will redirect based on role)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/appointments/book/{provider}', [DashboardController::class, 'bookingPage'])->name('appointments.book');
    Route::get('/appointments/available-slots/{provider}', [DashboardController::class, 'availableSlots'])->name('appointments.available-slots');
    Route::post('/appointments', [DashboardController::class, 'storeAppointment'])->name('appointments.store');
});


Route::get('test-logout', function () {
    Auth::logout();
    return redirect()->route('home');
});