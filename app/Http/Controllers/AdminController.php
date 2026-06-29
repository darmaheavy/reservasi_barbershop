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
        $dari   = $request->input('dari');   
        $sampai = $request->input('sampai'); 

        $bulan = (int) ($request->bulan ?? Carbon::now()->month);
        $tahun = (int) ($request->tahun ?? Carbon::now()->year);

        if ($dari && $sampai) {
            $tglMulai = Carbon::parse($dari)->startOfDay();
            $tglAkhir = Carbon::parse($sampai)->endOfDay();
            $bulan = $tglMulai->month;
            $tahun = $tglMulai->year;
        } else {
            $tglMulai = Carbon::create($tahun, $bulan, 1)->startOfDay();
            $tglAkhir = Carbon::create($tahun, $bulan, 1)->endOfMonth()->endOfDay();
            $dari   = null;
            $sampai = null;
        }

        $baseWhere = function ($q) use ($tglMulai, $tglAkhir) {
            $q->leftJoin('layanan', 'bookings.layanan', '=', 'layanan.nama')
              ->whereBetween('bookings.tanggal', [$tglMulai, $tglAkhir])
              ->where('bookings.status', 'selesai');
        };

        $totalPendapatan = DB::table('bookings')->tap($baseWhere)->sum(DB::raw('COALESCE(layanan.harga, 0)'));
        $totalReservasi = DB::table('bookings')->tap($baseWhere)->count();

        $perLayanan = DB::table('bookings')
            ->tap($baseWhere)
            ->selectRaw('bookings.layanan as service, SUM(COALESCE(layanan.harga, 0)) as total, COUNT(*) as jumlah')
            ->groupBy('bookings.layanan')
            ->orderByDesc('total')
            ->get();

        $detailTransaksi = DB::table('bookings')
            ->tap($baseWhere)
            ->selectRaw('bookings.nama as name, bookings.layanan as service, bookings.tanggal as date, COALESCE(layanan.harga, 0) as harga')
            ->orderByDesc('bookings.tanggal')
            ->get();

        $grafikHarian = DB::table('bookings')
            ->tap($baseWhere)
            ->selectRaw('DATE(bookings.tanggal) as tanggal, SUM(COALESCE(layanan.harga, 0)) as total, COUNT(*) as jumlah')
            ->groupBy(DB::raw('DATE(bookings.tanggal)'))
            ->orderBy('tanggal')
            ->get();

        return view('admin.laporan', compact(
            'dari', 'sampai', 'bulan', 'tahun',
            'totalPendapatan', 'totalReservasi',
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
    public function jadwal()
    {
        $jadwal = DB::table('jadwal')->get();
        return view('admin.jadwal', compact('jadwal'));
    }

    public function storeJadwal(Request $request)
    {
        $request->validate([
            'nama_hari'  => 'required',
            'jam_buka'   => 'nullable',
            'jam_tutup'  => 'nullable',
            'is_buka'    => 'required|boolean',
        ]);

        DB::table('jadwal')->insert([
            'nama_hari'  => $request->nama_hari,
            'jam_buka'   => $request->jam_buka,
            'jam_tutup'  => $request->jam_tutup,
            'is_buka'    => $request->is_buka,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return back()->with('success', 'Jadwal baru berhasil ditambahkan!');
    }

    public function updateJadwal(Request $request, $id)
    {
        // 1. Validasi request ditaruh paling atas
        $request->validate([
            'jam_buka'   => 'nullable',
            'jam_tutup'  => 'nullable',
            'is_buka'    => 'required|boolean',
        ]);

        // 2. Periksa konflik jika admin tidak melakukan "force_update"
        if (!$request->has('force_update')) {
            
            // Ambil data jadwal saat ini untuk mendeteksi ID hari (0 = Minggu, 1 = Senin, dst)
            $jadwal = DB::table('jadwal')->where('id', $id)->first();
            
            // Query dasar mencari reservasi aktif pelanggan pada hari tersebut
            $conflictsQuery = Booking::whereIn('status', ['pending', 'confirmed'])
             ->whereRaw("EXTRACT(DOW FROM tanggal) = ?", [$jadwal->hari]);
            // Kondisi A: Jika statusnya TETAP BUKA, cek jam operasional yang memotong/berada di luar jam baru
            if ($request->is_buka == 1) {
                $conflictsQuery->where(function($q) use ($request) {
                    $q->whereTime('jam', '<', $request->jam_buka)
                      ->orWhereTime('jam', '>', $request->jam_tutup);
                });
                $message = "Terdapat :count reservasi aktif pelanggan yang berada di luar jam operasional baru Anda.";
            } 
            // Kondisi B: Jika diubah menjadi TUTUP, semua reservasi aktif pada hari itu dianggap konflik
            else {
                $message = "Terdapat :count reservasi aktif pelanggan pada hari tersebut. Jika Anda menutup hari ini, jadwal booking mereka akan terdampak.";
            }

            $conflicts = $conflictsQuery->get();

            // Jika ditemukan data reservasi yang terdampak, batalkan proses & kirim data konflik ke session view
            if ($conflicts->count() > 0) {
                return back()->withInput()
                    ->with('conflict_data', $conflicts)
                    ->with('current_jadwal_id', $id) 
                    ->with('conflict_message', str_replace(':count', $conflicts->count(), $message));
            }
        }

        // 3. Jika tidak ada konflik (atau admin klik "Ya, Tetap Simpan"), jalankan proses update database
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

    public function deleteJadwal($id)
    {
        DB::table('jadwal')->where('id', $id)->delete();
        return back()->with('success', 'Jadwal berhasil dihapus!');
    }
}