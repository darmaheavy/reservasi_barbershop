<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Booking;

class BookingController extends Controller
{
    // ✅ tampilkan form booking
    public function create()
    {
        return view('user.booking');
    }

    // ✅ simpan data dari form
    public function store(Request $request)
    {
        // ✅ validasi input
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'layanan' => 'required|string',
            'tanggal' => 'required|date',
            'jam' => 'required',
            'whatsapp' => 'required|string|max:20',
        ]);

        // ✅ simpan ke database
        Booking::create([
            'user_id' => Auth::id(),
            'nama' => $validated['nama'],
            'layanan' => $validated['layanan'],
            'tanggal' => $validated['tanggal'],
            'jam' => $validated['jam'],
            'whatsapp' => $validated['whatsapp'],
            'status' => 'pending'
        ]);

        // ✅ redirect ke route yang SUDAH kita tambahkan di web.php
        return redirect()->route('booking.status')
            ->with('success', 'Booking berhasil!');
    }

    // ✅ halaman cek status booking
    public function status()
    {
        $bookings = Booking::where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('user.cek-status', compact('bookings'));
    }
}