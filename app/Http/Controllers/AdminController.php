<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalReservasi = Reservation::count();
        $pending = Reservation::where('status', 'pending')->count();
        $confirmed = Reservation::where('status', 'confirmed')->count();
        $cancelled = Reservation::where('status', 'cancelled')->count();

        return view('admin.dashboard', compact('totalReservasi', 'pending', 'confirmed', 'cancelled'));
    }

    public function reservations()
    {
        $reservations = Reservation::latest()->paginate(10);
        return view('admin.reservations', compact('reservations'));
    }

    public function updateStatus(Request $request, $id)
    {
        $reservation = Reservation::findOrFail($id);
        $reservation->update(['status' => $request->status]);
        return back()->with('success', 'Status reservasi berhasil diupdate!');
    }

    public function deleteReservation($id)
    {
        Reservation::findOrFail($id)->delete();
        return back()->with('success', 'Reservasi berhasil dihapus!');
    }



    // ─── Layanan ───────────────────────────────────────
public function showLayanan()
{
    $layanan = \Illuminate\Support\Facades\DB::table('layanan')->get();
    return view('admin.layanan', compact('layanan'));
}

public function storeLayanan(Request $request)
{
    $request->validate([
        'nama'      => 'required',
        'harga'     => 'required|numeric',
        'deskripsi' => 'required',
        'icon'      => 'nullable',
    ]);

    \Illuminate\Support\Facades\DB::table('layanan')->insert([
        'nama'       => $request->nama,
        'harga'      => $request->harga,
        'deskripsi'  => $request->deskripsi,
        'icon'       => $request->icon,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    return back()->with('success', 'Layanan berhasil ditambahkan!');
}

public function updateLayanan(Request $request, $id)
{
    $request->validate([
        'nama'      => 'required',
        'harga'     => 'required|numeric',
        'deskripsi' => 'required',
    ]);

    \Illuminate\Support\Facades\DB::table('layanan')->where('id', $id)->update([
        'nama'       => $request->nama,
        'harga'      => $request->harga,
        'deskripsi'  => $request->deskripsi,
        'icon'       => $request->icon,
        'updated_at' => now(),
    ]);

    return back()->with('success', 'Layanan berhasil diupdate!');
}

public function deleteLayanan($id)
{
    \Illuminate\Support\Facades\DB::table('layanan')->where('id', $id)->delete();
    return back()->with('success', 'Layanan berhasil dihapus!');
}

public function antrian()
{
    $today = \Carbon\Carbon::today()->toDateString();

    $antrian = Reservation::whereDate('date', $today)
        ->whereIn('status', ['pending', 'confirmed'])
        ->orderBy('time', 'asc')
        ->get();

    $mendatang = Reservation::whereDate('date', '>', $today)
        ->whereIn('status', ['pending', 'confirmed'])
        ->orderBy('date', 'asc')
        ->orderBy('time', 'asc')
        ->take(10)
        ->get();

    $totalHariIni = Reservation::whereDate('date', $today)->count();
    $pending = Reservation::whereDate('date', $today)->where('status', 'pending')->count();
    $confirmed = Reservation::whereDate('date', $today)->where('status', 'confirmed')->count();
    $cancelled = Reservation::whereDate('date', $today)->where('status', 'cancelled')->count();

    return view('admin.antrian', compact('antrian', 'mendatang', 'totalHariIni', 'pending', 'confirmed', 'cancelled'));
}
public function laporan(Request $request)
{
    $bulan = $request->bulan ?? \Carbon\Carbon::now()->month;
    $tahun = $request->tahun ?? \Carbon\Carbon::now()->year;

    $reservasiKonfirmasi = Reservation::whereMonth('date', $bulan)
        ->whereYear('date', $tahun)
        ->where('status', 'confirmed')
        ->get();

    $totalReservasi = $reservasiKonfirmasi->count();

    // Join dengan tabel layanan untuk ambil harga
    $totalPendapatan = \Illuminate\Support\Facades\DB::table('reservations')
        ->join('layanan', 'reservations.service', '=', 'layanan.nama')
        ->whereMonth('reservations.date', $bulan)
        ->whereYear('reservations.date', $tahun)
        ->where('reservations.status', 'confirmed')
        ->sum('layanan.harga');

    // Per layanan
    $perLayanan = \Illuminate\Support\Facades\DB::table('reservations')
        ->join('layanan', 'reservations.service', '=', 'layanan.nama')
        ->whereMonth('reservations.date', $bulan)
        ->whereYear('reservations.date', $tahun)
        ->where('reservations.status', 'confirmed')
        ->selectRaw('reservations.service, SUM(layanan.harga) as total, COUNT(*) as jumlah')
        ->groupBy('reservations.service')
        ->orderByDesc('total')
        ->get();

    // Grafik harian
    $grafikHarian = \Illuminate\Support\Facades\DB::table('reservations')
        ->join('layanan', 'reservations.service', '=', 'layanan.nama')
        ->whereMonth('reservations.date', $bulan)
        ->whereYear('reservations.date', $tahun)
        ->where('reservations.status', 'confirmed')
        ->selectRaw("TO_CHAR(reservations.date, 'DD') as tanggal, SUM(layanan.harga) as total")
        ->groupBy('tanggal')
        ->orderBy('tanggal')
        ->get();

    // Detail transaksi terbaru
    $detailTransaksi = \Illuminate\Support\Facades\DB::table('reservations')
        ->join('layanan', 'reservations.service', '=', 'layanan.nama')
        ->whereMonth('reservations.date', $bulan)
        ->whereYear('reservations.date', $tahun)
        ->where('reservations.status', 'confirmed')
        ->selectRaw('reservations.name, reservations.service, reservations.date, layanan.harga')
        ->orderByDesc('reservations.date')
        ->take(8)
        ->get();

    return view('admin.laporan', compact(
        'bulan', 'tahun', 'totalPendapatan', 'totalReservasi',
        'perLayanan', 'grafikHarian', 'detailTransaksi'
    ));
}
public function status()
{
    $reservations = \App\Models\Reservation::latest()->get();

    return view('admin.status', compact('reservations'));
}

}

