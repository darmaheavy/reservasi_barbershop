<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalReservasi = Booking::count();
        $pending = Booking::where('status', 'pending')->count();
        $confirmed = Booking::where('status', 'confirmed')->count();
        $cancelled = Booking::where('status', 'cancelled')->count();
        $reservasiTerbaru = Booking::latest()->take(5)->get();

        return view('admin.dashboard', compact('totalReservasi', 'pending', 'confirmed', 'cancelled', 'reservasiTerbaru'));
    }

    public function reservations()
    {
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
        $bulan = (int) ($request->bulan ?? Carbon::now()->month);
        $tahun = (int) ($request->tahun ?? Carbon::now()->year);

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

        // FIXED: alias 'service' → 'layanan' agar cocok dengan $l->layanan di view
        $perLayanan = DB::table('bookings')
            ->join('layanan', 'bookings.layanan', '=', 'layanan.nama')
            ->whereMonth('bookings.tanggal', $bulan)
            ->whereYear('bookings.tanggal', $tahun)
            ->where('bookings.status', 'confirmed')
            ->selectRaw('bookings.layanan as layanan, SUM(layanan.harga) as total, COUNT(*) as jumlah')
            ->groupBy('bookings.layanan')
            ->orderByDesc('total')
            ->get();

        // FIXED: alias 'name'→'nama', 'service'→'layanan', 'date'→'tanggal' agar cocok dengan view
        $detailTransaksi = DB::table('bookings')
            ->join('layanan', 'bookings.layanan', '=', 'layanan.nama')
            ->whereMonth('bookings.tanggal', $bulan)
            ->whereYear('bookings.tanggal', $tahun)
            ->where('bookings.status', 'confirmed')
            ->selectRaw('bookings.nama as nama, bookings.layanan as layanan, bookings.tanggal as tanggal, layanan.harga')
            ->orderByDesc('bookings.tanggal')
            ->limit(10)
            ->get();

        $grafikHarian = DB::table('bookings')
            ->join('layanan', 'bookings.layanan', '=', 'layanan.nama')
            ->whereMonth('bookings.tanggal', $bulan)
            ->whereYear('bookings.tanggal', $tahun)
            ->where('bookings.status', 'confirmed')
            ->selectRaw('DATE(bookings.tanggal) as tanggal, SUM(layanan.harga) as total')
            ->groupBy(DB::raw('DATE(bookings.tanggal)'))
            ->orderBy('tanggal')
            ->get();

        return view('admin.laporan', compact(
            'bulan', 'tahun', 'totalPendapatan', 'totalReservasi',
            'perLayanan', 'detailTransaksi', 'grafikHarian'
        ));
    }

    public function status()
    {
        $reservations = Booking::latest()->get();
        return view('admin.status', compact('reservations'));
    }
}