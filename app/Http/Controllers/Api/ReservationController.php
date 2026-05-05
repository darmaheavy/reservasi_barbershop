<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    public function index() { 
        // Mengambil semua data reservasi (untuk Admin)
        return response()->json(Reservation::with('user', 'service')->get()); 
    }

    public function store(Request $request) {
        // 1. Validasi input
        $request->validate([
            'nomor_wa'   => 'required',
            'id_service' => 'required|exists:services,id',
        ]);

        // 2. Logika waktu disesuaikan ke kolom jadwal_reservasi
        $waktu = $request->jadwal_reservasi; // Diubah dari jam_mulai
        if ($request->has('tanggal') && $request->has('jam')) {
            $waktu = $request->tanggal . ' ' . $request->jam . ':00';
        }

        // 3. Simpan data dengan nama kolom baru
        $res = Reservation::create([
            'user_id'          => Auth::id(),
            'nama_pelanggan'   => Auth::user()->name,
            'nomor_wa'         => $request->nomor_wa,
            'jadwal_reservasi' => $waktu, // Diubah dari jam_mulai
            'id_service'       => $request->id_service,
            'status'           => 'pending',
        ]);

        return response()->json($res, 201);
    }

    public function show($id) {
        return response()->json(Reservation::with('user', 'service')->findOrFail($id));
    }

    public function update(Request $request, $id) {
        $res = Reservation::findOrFail($id);

        // Keamanan: Hanya pemilik reservasi atau admin yang boleh update
        if (Auth::id() !== $res->user_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $data = $request->all();

        // Logika update waktu untuk kolom baru
        if ($request->has('tanggal') && $request->has('jam')) {
            $data['jadwal_reservasi'] = $request->tanggal . ' ' . $request->jam . ':00'; // Diubah dari jam_mulai
        }

        $res->update($data);
        return response()->json($res);
    }

    public function destroy($id) {
        $res = Reservation::findOrFail($id);
        
        if (Auth::id() !== $res->user_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $res->delete();
        return response()->json(['message' => 'Reservation Deleted']);
    }

    public function myReservations() {
        $history = Reservation::where('user_id', Auth::id())->with('service')->get();
        return response()->json($history);
    }
}