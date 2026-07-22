<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\ProgressLogController;
use App\Http\Controllers\MonitoringController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\GuideController;
use App\Http\Controllers\ProfileController;

// Redirect root to dashboard or login
Route::get('/', function () {
    return auth()->check() 
        ? redirect()->route('dashboard') 
        : redirect()->route('login');
});

// Guest Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// Authenticated Routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Activities Management (CRUD)
    Route::resource('activities', ActivityController::class);

    // Progress Log Update
    Route::post('/activities/{activity}/progress', [ProgressLogController::class, 'store'])
        ->name('activities.progress.store');

    // Dashboard Monitoring (Calendar & Visual Cards)
    Route::get('/monitoring', [MonitoringController::class, 'index'])->name('monitoring.index');

    // Reports & PDF Export
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/pdf', [ReportController::class, 'exportPdf'])->name('reports.pdf');

    // Technical Guide / Petunjuk Penggunaan
    Route::get('/guide', [GuideController::class, 'index'])->name('guide.index');

    // User Profile
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});
