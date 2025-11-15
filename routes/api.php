<?php

use App\Http\Controllers\Api\AppointmentApiController;
use App\Http\Controllers\Api\PaymentApiController;
use App\Http\Controllers\Api\ProviderApiController;
use App\Http\Controllers\Api\ReviewApiController;
use App\Http\Controllers\Api\SalonApiController;
use App\Http\Controllers\Api\ServiceApiController;
use Illuminate\Support\Facades\Route;

// Public API Routes
Route::get('/salons', [SalonApiController::class, 'index']);
Route::get('/salons/{id}', [SalonApiController::class, 'show']);
Route::get('/salons/{id}/providers', [SalonApiController::class, 'providers']);

Route::get('/providers', [ProviderApiController::class, 'index']);
Route::get('/providers/{id}', [ProviderApiController::class, 'show']);
Route::get('/providers/{id}/available-slots', [ProviderApiController::class, 'availableSlots']);
Route::get('/providers/{id}/reviews', [ProviderApiController::class, 'reviews']);

Route::get('/services', [ServiceApiController::class, 'index']);
Route::get('/services/{id}', [ServiceApiController::class, 'show']);

// Authenticated API Routes
Route::middleware('auth:sanctum')->group(function () {
    // Appointments
    Route::get('/appointments', [AppointmentApiController::class, 'index']);
    Route::post('/appointments', [AppointmentApiController::class, 'store']);
    Route::get('/appointments/{id}', [AppointmentApiController::class, 'show']);
    Route::put('/appointments/{id}', [AppointmentApiController::class, 'update']);
    Route::delete('/appointments/{id}', [AppointmentApiController::class, 'destroy']);

    // Payments
    Route::post('/payments', [PaymentApiController::class, 'store']);
    Route::post('/payments/{id}/confirm', [PaymentApiController::class, 'confirm']);
    Route::get('/payments/{id}', [PaymentApiController::class, 'show']);

    // Reviews
    Route::get('/reviews', [ReviewApiController::class, 'index']);
    Route::post('/reviews', [ReviewApiController::class, 'store']);
    Route::get('/reviews/{id}', [ReviewApiController::class, 'show']);
});
