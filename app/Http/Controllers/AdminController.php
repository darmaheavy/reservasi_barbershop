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
        $selesai = Booking::where('status', 'selesai')->count();
        $reservasiTerbaru = Booking::latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalReservasi', 'pending', 'confirmed', 'cancelled', 'selesai', 'reservasiTerbaru'
        ));
    }

    public function reservations()
    {
        $reservations = Booking::latest()->paginate(10);
        return view('admin.reservations', compact('reservations'));
    }

    public function updateStatus(Request $request, $id)
    {
        $reservation = Booking::findOrFail($id);
        $reservation->update([
            'status'     => $request->status,
            'updated_at' => now(),
        ]);
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

    // ─── Antrian ───────────────────────────────────────
    public function antrian()
    {
        $today = Carbon::today()->toDateString();

        $antrian = Booking::whereDate('tanggal', $today)
            ->whereIn('status', ['pending', 'confirmed', 'selesai'])
            ->orderBy('jam', 'asc')
            ->get();

        $mendatang = Booking::whereDate('tanggal', '>', $today)
            ->whereIn('status', ['pending', 'confirmed'])
            ->orderBy('tanggal', 'asc')
            ->orderBy('jam', 'asc')
            ->take(10)
            ->get();

        $totalHariIni = Booking::whereDate('tanggal', $today)->count();
        $pending      = Booking::whereDate('tanggal', $today)->where('status', 'pending')->count();
        $confirmed    = Booking::whereDate('tanggal', $today)->where('status', 'confirmed')->count();
        $cancelled    = Booking::whereDate('tanggal', $today)->where('status', 'cancelled')->count();
        $selesai      = Booking::whereDate('tanggal', $today)->where('status', 'selesai')->count();

        return view('admin.antrian', compact(
            'antrian', 'mendatang', 'totalHariIni',
            'pending', 'confirmed', 'cancelled', 'selesai'
        ));
    }

    // ─── Laporan ───────────────────────────────────────
    public function laporan(Request $request)
    {
        $bulan = (int) ($request->bulan ?? Carbon::now()->month);
        $tahun = (int) ($request->tahun ?? Carbon::now()->year);

        $totalPendapatan = DB::table('bookings')
            ->join('layanan', 'bookings.layanan', '=', 'layanan.nama')
            ->whereMonth('bookings.tanggal', $bulan)
            ->whereYear('bookings.tanggal', $tahun)
            ->where('bookings.status', 'selesai')
            ->sum('layanan.harga');

        $totalReservasi = Booking::whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->where('status', 'selesai')
            ->count();

        $perLayanan = DB::table('bookings')
            ->join('layanan', 'bookings.layanan', '=', 'layanan.nama')
            ->whereMonth('bookings.tanggal', $bulan)
            ->whereYear('bookings.tanggal', $tahun)
            ->where('bookings.status', 'selesai')
            ->selectRaw('bookings.layanan as service, SUM(layanan.harga) as total, COUNT(*) as jumlah')
            ->groupBy('bookings.layanan')
            ->orderByDesc('total')
            ->get();

        $detailTransaksi = DB::table('bookings')
            ->join('layanan', 'bookings.layanan', '=', 'layanan.nama')
            ->whereMonth('bookings.tanggal', $bulan)
            ->whereYear('bookings.tanggal', $tahun)
            ->where('bookings.status', 'selesai')
            ->selectRaw('bookings.nama as name, bookings.layanan as service, bookings.tanggal as date, layanan.harga')
            ->orderByDesc('bookings.tanggal')
            ->limit(10)
            ->get();

        $grafikHarian = DB::table('bookings')
            ->join('layanan', 'bookings.layanan', '=', 'layanan.nama')
            ->whereMonth('bookings.tanggal', $bulan)
            ->whereYear('bookings.tanggal', $tahun)
            ->where('bookings.status', 'selesai')
            ->selectRaw('DATE(bookings.tanggal) as tanggal, SUM(layanan.harga) as total')
            ->groupBy(DB::raw('DATE(bookings.tanggal)'))
            ->orderBy('tanggal')
            ->get();

        return view('admin.laporan', compact(
            'bulan', 'tahun', 'totalPendapatan', 'totalReservasi',
            'perLayanan', 'detailTransaksi', 'grafikHarian'
        ));
    }

    // ─── Status ───────────────────────────────────────
    public function status()
    {
        $reservations = Booking::latest()->get();
        return view('admin.status', compact('reservations'));
    }

    // ─── Galeri ───────────────────────────────────────
    public function galeri()
    {
        $galeri = DB::table('galeri')->latest()->get();
        return view('admin.galeri', compact('galeri'));
    }

    public function storeGaleri(Request $request)
    {
        $request->validate([
            'foto' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $path = $request->file('foto')->store('galeri', 'public');

        DB::table('galeri')->insert([
            'foto'       => $path,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return back()->with('success', 'Foto berhasil diupload!');
    }

    public function deleteGaleri($id)
    {
        $foto = DB::table('galeri')->where('id', $id)->first();
        if ($foto) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($foto->foto);
            DB::table('galeri')->where('id', $id)->delete();
        }
        return back()->with('success', 'Foto berhasil dihapus!');
    }


    // ─── Jadwal ───────────────────────────────────────
// ─── Jadwal ───────────────────────────────────────
public function jadwal()
{
    $jadwal = DB::table('jadwal')
        ->orderBy('hari', 'asc')
        ->get();

    return view('admin.jadwal', compact('jadwal'));
}

public function updateJadwal(Request $request, $id)
{
    $request->validate([
        'jam_buka'  => 'nullable|date_format:H:i',
        'jam_tutup' => 'nullable|date_format:H:i|after:jam_buka',
        'is_buka'   => 'required|boolean',
    ]);

    DB::table('jadwal')
        ->where('id', $id)
        ->update([
            'jam_buka'   => $request->jam_buka,
            'jam_tutup'  => $request->jam_tutup,
            'is_buka'    => $request->is_buka,
            'updated_at' => now(),
        ]);

    return back()->with('success', 'Jadwal berhasil diupdate!');
}
}


    // ─── Jadwal ───────────────────────────────────────
   