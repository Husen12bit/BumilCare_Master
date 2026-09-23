<?php

use App\Http\Controllers\Auth\WebAuthController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\PatientDetailController;
use App\Http\Controllers\Dashboard\PatientListController;
use App\Http\Controllers\Web\Bumil\BumilAuthController;
use App\Http\Controllers\Web\Bumil\EmergencyWebController;
use App\Http\Controllers\Web\Bumil\KiaWebController;
use App\Http\Controllers\Web\Bumil\ScreeningWebController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// ============ ROOT REDIRECT ============
Route::get('/', function () {
    if (! Auth::check()) return redirect()->route('bumil.login');
    return Auth::user()->role->value === 'nakes'
        ? redirect()->route('dashboard')
        : redirect()->route('bumil.screening');
});

// ============ NAKES ROUTES ============
Route::middleware('guest')->group(function () {
    Route::get('/login', [WebAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [WebAuthController::class, 'login']);
});

Route::post('/logout', [WebAuthController::class, 'logout'])
    ->middleware('auth')->name('logout');

Route::middleware(['auth', 'role:nakes'])->prefix('dashboard')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/patients', [PatientListController::class, 'index'])->name('patients.index');
    Route::get('/patients/{patient}', [PatientDetailController::class, 'show'])->name('patients.show');
});

// ============ BUMIL WEB CLIENT (MOBILE-FIRST) ============
Route::prefix('app')->name('bumil.')->group(function () {
    // Auth (guest bumil)
    Route::middleware('guest')->group(function () {
        Route::get('/login', [BumilAuthController::class, 'showLogin'])->name('login');
        Route::post('/login', [BumilAuthController::class, 'login']);
        Route::get('/register', [BumilAuthController::class, 'showRegister'])->name('register');
        Route::post('/register', [BumilAuthController::class, 'register']);
    });

    // Area bumil (harus login + role bumil)
    Route::middleware(['auth', 'role:bumil'])->group(function () {
        Route::post('/logout', [BumilAuthController::class, 'logout'])->name('logout');

        // Tab 1: Skrining
        Route::get('/', [ScreeningWebController::class, 'index'])->name('screening');
        Route::post('/screening', [ScreeningWebController::class, 'store'])->name('screening.store');

        // Tab 2: Kartu KIA
        Route::get('/kia', [KiaWebController::class, 'index'])->name('kia');
        Route::post('/kia/ttd', [KiaWebController::class, 'updateTtd'])->name('kia.ttd');

        // Tab 3: Darurat
        Route::get('/emergency', [EmergencyWebController::class, 'index'])->name('emergency');

        // Profil
        Route::get('/profile', [BumilAuthController::class, 'showProfile'])->name('profile');
        Route::put('/profile', [BumilAuthController::class, 'updateProfile'])->name('profile.update');
    });
});
