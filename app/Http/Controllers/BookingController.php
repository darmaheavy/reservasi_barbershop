<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; // Tambahkan ini untuk akses DB
use App\Models\Booking;

class BookingController extends Controller
{
    // ✅ tampilkan form booking dengan data layanan dinamis
    public function create()
    {
        // Ambil semua data dari tabel layanan agar muncul di dropdown form
        $layanan = DB::table('layanan')->get();

        // Kirim variabel $layanan ke view user.booking
        return view('user.booking', compact('layanan'));
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

        // ✅ simpan ke database (pastikan Model Booking sudah diarahkan ke tabel 'bookings')
        Booking::create([
            'user_id' => Auth::id(),
            'nama' => $validated['nama'],
            'layanan' => $validated['layanan'], // Ini akan berisi nama layanan yang dipilih user
            'tanggal' => $validated['tanggal'],
            'jam' => $validated['jam'],
            'whatsapp' => $validated['whatsapp'],
            'status' => 'pending'
        ]);

        // ✅ redirect ke halaman status
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