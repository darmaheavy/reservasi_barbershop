<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Booking;
use Carbon\Carbon;

class BookingController extends Controller
{
    // ─────────────────────────────────────────────
    // Generate slot berdasarkan jam buka & tutup
    // ─────────────────────────────────────────────
    private function generateSlots(string $jamBuka, string $jamTutup): array
    {
        $slots = [];

        $start = Carbon::createFromFormat('H:i:s', $jamBuka);
        $end   = Carbon::createFromFormat('H:i:s', $jamTutup);

        while ($start->lt($end)) {
            $slots[] = $start->format('H:i');
            $start->addMinutes(45);
        }

        return $slots;
    }

    // ─────────────────────────────────────────────
    // Form booking
    // ─────────────────────────────────────────────
    public function create()
    {
        $layanan = DB::table('layanan')->get();

        return view('user.booking', compact('layanan'));
    }

    // ─────────────────────────────────────────────
    // API SLOT BOOKING
    // ─────────────────────────────────────────────
    public function getSlot(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date'
        ]);

        $tanggal = $request->tanggal;

        // 0 = Minggu
        $hari = Carbon::parse($tanggal)->dayOfWeek;

        // Ambil jadwal
        $jadwal = DB::table('jadwal')
            ->where('hari', $hari)
            ->first();

        // Jika jadwal tidak ada
        if (!$jadwal) {
            return response()->json([
                'libur' => true,
                'pesan' => 'Jadwal tidak tersedia'
            ]);
        }

        // Jika hari ditutup admin
        if (!$jadwal->is_buka) {
            return response()->json([
                'libur' => true,
                'pesan' => 'Barbershop tutup pada hari ' . $jadwal->nama_hari
            ]);
        }

        // Generate semua slot
        $allSlots = $this->generateSlots(
            $jadwal->jam_buka,
            $jadwal->jam_tutup
        );

        // Booking existing
        $bookedJam = Booking::whereDate('tanggal', $tanggal)
            ->whereIn('status', ['pending', 'confirmed'])
            ->pluck('jam')
            ->map(function ($jam) {
                return Carbon::parse($jam)->format('H:i');
            })
            ->toArray();

        $slots = [];

        foreach ($allSlots as $jam) {

            $isBooked = in_array($jam, $bookedJam);

            // Cek apakah jam sudah lewat
            $isPast = Carbon::parse($tanggal . ' ' . $jam)
                ->lt(Carbon::now());

            $tersedia = !$isBooked && !$isPast;

            $label = 'Tersedia';

            if ($isBooked) {
                $label = 'Penuh';
            }

            if ($isPast) {
                $label = 'Lewat';
            }

            $slots[] = [
                'jam'       => $jam,
                'tersedia'  => $tersedia,
                'label'     => $label,
            ];
        }

        return response()->json([
            'libur' => false,
            'slots' => $slots
        ]);
    }

    // ─────────────────────────────────────────────
    // Simpan booking
    // ─────────────────────────────────────────────
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'     => 'required|string|max:255',
            'layanan'  => 'required|string',
            'tanggal'  => 'required|date|after_or_equal:today',
            'jam'      => 'required',
            'whatsapp' => 'required|string|max:20',
        ]);

        // Ambil hari
        $hari = Carbon::parse($validated['tanggal'])->dayOfWeek;

        // Ambil jadwal
        $jadwal = DB::table('jadwal')
            ->where('hari', $hari)
            ->first();

        // Cek apakah hari buka
        if (!$jadwal || !$jadwal->is_buka) {
            return back()
                ->withInput()
                ->withErrors([
                    'tanggal' => 'Barbershop tutup pada hari tersebut.'
                ]);
        }

        // Cek slot sudah dibooking
        $sudahDibooking = Booking::whereDate('tanggal', $validated['tanggal'])
            ->whereTime('jam', $validated['jam'])
            ->whereIn('status', ['pending', 'confirmed'])
            ->exists();

        if ($sudahDibooking) {
            return back()
                ->withInput()
                ->withErrors([
                    'jam' => 'Slot jam sudah dibooking.'
                ]);
        }

        // Cek jam lewat
        $datetimeBooking = Carbon::parse(
            $validated['tanggal'] . ' ' . $validated['jam']
        );

        if ($datetimeBooking->lt(Carbon::now())) {
            return back()
                ->withInput()
                ->withErrors([
                    'jam' => 'Jam booking sudah lewat.'
                ]);
        }

        // Simpan booking
        Booking::create([
            'user_id'  => Auth::id(),
            'nama'     => $validated['nama'],
            'layanan'  => $validated['layanan'],
            'tanggal'  => $validated['tanggal'],
            'jam'      => $validated['jam'],
            'whatsapp' => $validated['whatsapp'],
            'status'   => 'pending',
        ]);

        return redirect()
            ->route('booking.status')
            ->with(
                'success',
                'Booking berhasil dibuat! Silakan tunggu konfirmasi admin.'
            );
    }

    // ─────────────────────────────────────────────
    // Status booking user
    // ─────────────────────────────────────────────
    public function status()
    {
        $bookings = Booking::where('user_id', Auth::id())
            ->orderBy('tanggal', 'desc')
            ->orderBy('jam', 'desc')
            ->get();

        return view('user.cek-status', compact('bookings'));
    }
}