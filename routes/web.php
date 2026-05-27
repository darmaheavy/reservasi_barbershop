<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\GaleriController;

// ✅ HALAMAN UTAMA
Route::get('/', function () {
    $galeri = \App\Models\Galeri::latest()->get();
    $layanan = \App\Models\Layanan::all();

    return view('welcome', compact('galeri', 'layanan'));
});

// ✅ DASHBOARD USER
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
    Route::get('/booking/status', [BookingController::class, 'status'])->name('booking.status');
    Route::get('/booking/slots', [BookingController::class, 'getSlot'])->name('booking.slots');
});

require __DIR__.'/auth.php';

// ✅ ADMIN
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // ✅ DASHBOARD
        Route::get('/dashboard', [AdminController::class, 'dashboard'])
            ->name('dashboard');

        // ✅ RESERVATIONS
        Route::get('/reservations', [AdminController::class, 'reservations'])
            ->name('reservations');

        Route::put('/reservations/{id}/status', [AdminController::class, 'updateStatus'])
            ->name('reservations.status');

        Route::delete('/reservations/{id}', [AdminController::class, 'deleteReservation'])
            ->name('reservations.delete');

        // ✅ LAYANAN
        Route::get('/layanan', [AdminController::class, 'showLayanan'])
            ->name('layanan');

        Route::post('/layanan', [AdminController::class, 'storeLayanan'])
            ->name('layanan.store');

        Route::put('/layanan/{id}', [AdminController::class, 'updateLayanan'])
            ->name('layanan.update');

        Route::delete('/layanan/{id}', [AdminController::class, 'deleteLayanan'])
            ->name('layanan.delete');

        // ✅ STATUS
        Route::get('/status', [AdminController::class, 'status'])
            ->name('status');

        // ✅ ANTRIAN
        Route::get('/antrian', [AdminController::class, 'antrian'])
            ->name('antrian');

        // ✅ LAPORAN
        Route::get('/laporan', [AdminController::class, 'laporan'])
            ->name('laporan');

        // ✅ JADWAL CRUD
        Route::get('/jadwal', [AdminController::class, 'jadwal'])
            ->name('jadwal');

        Route::post('/jadwal', [AdminController::class, 'storeJadwal'])
            ->name('jadwal.store');

        Route::put('/jadwal/{id}', [AdminController::class, 'updateJadwal'])
            ->name('jadwal.update');

        Route::delete('/jadwal/{id}', [AdminController::class, 'deleteJadwal'])
            ->name('jadwal.delete');

        // ✅ GALERI
        Route::get('/galeri', [GaleriController::class, 'index'])
            ->name('galeri');

        Route::post('/galeri', [GaleriController::class, 'store'])
            ->name('galeri.store');

        Route::delete('/galeri/{id}', [GaleriController::class, 'destroy'])
            ->name('galeri.destroy');
    });