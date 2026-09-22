<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PatientHistoryController;
use App\Http\Controllers\Api\ScreeningController;
use App\Http\Controllers\Api\PatientController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::post('/login', [AuthController::class, 'login']);

// Protected routes (butuh token Sanctum)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/screening', [ScreeningController::class, 'store']);
    Route::get('/patient/history', [PatientHistoryController::class, 'index']);
});

Route::post('/register', [AuthController::class, 'register']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/patient/profile', [PatientController::class, 'show']);
    Route::put('/patient/profile', [PatientController::class, 'update']);
    // ... route lain
});
