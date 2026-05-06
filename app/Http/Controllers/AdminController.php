<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking; // Menggunakan model yang sudah diarahkan ke tabel 'bookings'
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Mengambil data statistik dari tabel bookings
        $totalReservasi = Booking::count();
        $pending = Booking::where('status', 'pending')->count();
        $confirmed = Booking::where('status', 'confirmed')->count();
        $cancelled = Booking::where('status', 'cancelled')->count();

        // Mengambil data terbaru untuk ditampilkan di dashboard
        $reservasiTerbaru = Booking::latest()->take(5)->get();

        return view('admin.dashboard', compact('totalReservasi', 'pending', 'confirmed', 'cancelled', 'reservasiTerbaru'));
    }

    public function reservations()
    {
        // Menampilkan daftar semua data dari tabel bookings
        $reservations = Booking::latest()->paginate(10);
        return view('admin.reservations', compact('reservations'));
    }

    public function updateStatus(Request $request, $id)
    {
        $reservation = Booking::findOrFail($id);
        $reservation->update(['status' => $request->status]);
        return back()->with('success', 'Status reservasi berhasil diupdate!');
    }

    public function deleteReservation($id)
    {
        Booking::findOrFail($id)->delete();
        return back()->with('success', 'Reservasi berhasil dihapus!');
    }

    // ─── Layanan ───────────────────────────────────────
    public function showLayanan()
    {
        $layanan = DB::table('layanan')->get();
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

        DB::table('layanan')->insert([
            'nama'       => $request->nama,
            'harga'      => $request->harga,
            'deskripsi'  => $request->deskripsi,
            // Simpan NULL jika input kosong atau teks 'KOSONG'
            'icon'       => (empty($request->icon) || $request->icon === 'KOSONG') ? null : $request->icon,
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
            'icon'      => 'nullable',
        ]);

        DB::table('layanan')->where('id', $id)->update([
            'nama'       => $request->nama,
            'harga'      => $request->harga,
            'deskripsi'  => $request->deskripsi,
            'icon'       => (empty($request->icon) || $request->icon === 'KOSONG') ? null : $request->icon,
            'updated_at' => now(),
        ]);

        return back()->with('success', 'Layanan berhasil diupdate!');
    }

    public function deleteLayanan($id)
    {
        DB::table('layanan')->where('id', $id)->delete();
        return back()->with('success', 'Layanan berhasil dihapus!');
    }

    public function antrian()
    {
        $today = Carbon::today()->toDateString();

        // Menyesuaikan kolom 'tanggal' dan 'jam' sesuai tabel bookings
        $antrian = Booking::whereDate('tanggal', $today)
            ->whereIn('status', ['pending', 'confirmed'])
            ->orderBy('jam', 'asc')
            ->get();

        $mendatang = Booking::whereDate('tanggal', '>', $today)
            ->whereIn('status', ['pending', 'confirmed'])
            ->orderBy('tanggal', 'asc')
            ->orderBy('jam', 'asc')
            ->take(10)
            ->get();

        $totalHariIni = Booking::whereDate('tanggal', $today)->count();
        $pending = Booking::whereDate('tanggal', $today)->where('status', 'pending')->count();
        $confirmed = Booking::whereDate('tanggal', $today)->where('status', 'confirmed')->count();
        $cancelled = Booking::whereDate('tanggal', $today)->where('status', 'cancelled')->count();

        return view('admin.antrian', compact('antrian', 'mendatang', 'totalHariIni', 'pending', 'confirmed', 'cancelled'));
    }

    public function laporan(Request $request)
    {
        $bulan = $request->bulan ?? Carbon::now()->month;
        $tahun = $request->tahun ?? Carbon::now()->year;

        // Sinkronisasi Join antara tabel bookings dan layanan
        $totalPendapatan = DB::table('bookings')
            ->join('layanan', 'bookings.layanan', '=', 'layanan.nama')
            ->whereMonth('bookings.tanggal', $bulan)
            ->whereYear('bookings.tanggal', $tahun)
            ->where('bookings.status', 'confirmed')
            ->sum('layanan.harga');

        $totalReservasi = Booking::whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->where('status', 'confirmed')
            ->count();

        // Per layanan
        $perLayanan = DB::table('bookings')
            ->join('layanan', 'bookings.layanan', '=', 'layanan.nama')
            ->whereMonth('bookings.tanggal', $bulan)
            ->whereYear('bookings.tanggal', $tahun)
            ->where('bookings.status', 'confirmed')
            ->selectRaw('bookings.layanan as service, SUM(layanan.harga) as total, COUNT(*) as jumlah')
            ->groupBy('bookings.layanan')
            ->orderByDesc('total')
            ->get();

        return view('admin.laporan', compact(
            'bulan', 'tahun', 'totalPendapatan', 'totalReservasi', 'perLayanan'
        ));
    }

    public function status()
    {
        $reservations = Booking::latest()->get();
        return view('admin.status', compact('reservations'));
    }
}