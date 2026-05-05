<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Booking;

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil data booking terakhir milik user
        $res = Booking::where('user_id', Auth::id())
            ->latest()
            ->first();

        // Pastikan tetap kirim variable walaupun null
        return view('user.dashboard', [
            'res' => $res
        ]);
    }
}