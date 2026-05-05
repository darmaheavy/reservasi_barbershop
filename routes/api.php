<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ReservationController;

/*
|--------------------------------------------------------------------------
| Public Routes (Bisa diakses tanpa login)
|--------------------------------------------------------------------------
*/
// 1. Letakkan filter di paling atas agar tidak tertukar dengan {id}
Route::get('/reservations/filter', [ReservationController::class, 'filterByStatus']);

// 2. Route index dan show untuk melihat data secara umum
Route::get('/reservations', [ReservationController::class, 'index']);
Route::get('/reservations/{reservation}', [ReservationController::class, 'show']);


/*
|--------------------------------------------------------------------------
| Protected Routes (Wajib Login / Pakai Token)
|--------------------------------------------------------------------------
*/
Route::middleware('auth:sanctum')->group(function () {
    
    // Fitur khusus riwayat booking milik user sendiri
    Route::get('/my-reservations', [ReservationController::class, 'myReservations']);

    // Aksi yang mengubah data (Wajib Login)
    Route::post('/reservations', [ReservationController::class, 'store']);
    Route::put('/reservations/{id}', [ReservationController::class, 'update']);
    Route::delete('/reservations/{id}', [ReservationController::class, 'destroy']);
    
});