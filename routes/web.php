<?php

use App\Http\Controllers\Auth\WebAuthController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\PatientDetailController;
use App\Http\Controllers\Dashboard\PatientListController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Root redirect
Route::get('/', function () {
    return Auth::check()
        ? redirect()->route('dashboard')
        : redirect()->route('login');
});

// Auth (guest only)
Route::middleware('guest')->group(function () {
    Route::get('/login', [WebAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [WebAuthController::class, 'login']);
});

// Logout (auth required)
Route::post('/logout', [WebAuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// Dashboard (butuh login + role nakes)
Route::middleware(['auth', 'role:nakes'])->prefix('dashboard')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/patients', [PatientListController::class, 'index'])->name('patients.index');
    Route::get('/patients/{patient}', [PatientDetailController::class, 'show'])->name('patients.show');
});
