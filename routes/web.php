<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BookingController;

Route::get('/', function () {
    return view('welcome');
});

// ✅ DASHBOARD
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// ✅ USER AUTH
Route::middleware('auth')->group(function () {

    // PROFILE
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ✅ BOOKING
    Route::get('/booking', [BookingController::class, 'create'])->name('booking.create');
    Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');

    // 🔥 TAMBAHAN INI (BIAR ERROR HILANG)
    Route::get('/booking/status', [BookingController::class, 'status'])->name('booking.status');
});

require __DIR__.'/auth.php';

// ✅ ADMIN
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

        Route::get('/reservations', [AdminController::class, 'reservations'])->name('reservations');

        Route::put('/reservations/{id}/status', [AdminController::class, 'updateStatus'])->name('reservations.status');

        Route::delete('/reservations/{id}', [AdminController::class, 'deleteReservation'])->name('reservations.delete');

        Route::get('/layanan', [AdminController::class, 'showLayanan'])->name('layanan');
        Route::post('/layanan', [AdminController::class, 'storeLayanan'])->name('layanan.store');
        Route::put('/layanan/{id}', [AdminController::class, 'updateLayanan'])->name('layanan.update');
        Route::delete('/layanan/{id}', [AdminController::class, 'deleteLayanan'])->name('layanan.delete');

        Route::get('/status', [AdminController::class, 'status'])->name('status');
        Route::get('/antrian', [AdminController::class, 'antrian'])->name('antrian');
        Route::get('/laporan', [AdminController::class, 'laporan'])->name('laporan');
    });
