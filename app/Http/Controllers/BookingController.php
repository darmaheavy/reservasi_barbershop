<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Booking;

class BookingController extends Controller
{
    public function create()
    {
        $layanan = DB::table('layanan')->get();
        return view('user.booking', compact('layanan'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'layanan' => 'required|string',
            'tanggal' => 'required|date',
            'jam' => 'required',
            'whatsapp' => 'required|string|max:20',
        ]);

        Booking::create([
            'user_id' => Auth::id(), // Pastikan user login
            'nama' => $validated['nama'],
            'layanan' => $validated['layanan'],
            'tanggal' => $validated['tanggal'],
            'jam' => $validated['jam'],
            'whatsapp' => $validated['whatsapp'],
            'status' => 'pending'
        ]);

        return redirect()->route('booking.status')
            ->with('success', 'Booking berhasil dibuat!');
    }

    public function status()
    {
        // Mengambil SEMUA booking milik user yang sedang login
        $bookings = Booking::where('user_id', Auth::id())
            ->orderBy('tanggal', 'desc')
            ->orderBy('jam', 'desc')
            ->get();

        return view('user.cek-status', compact('bookings'));
    }
}