<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monitoring Antrian — Mr. Brokker</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'DM Sans', sans-serif; }
        .font-display { font-family: 'Playfair Display', serif; }
        .sidebar-link { transition: all 0.2s; }
        .sidebar-link:hover, .sidebar-link.active { background: rgba(234,179,8,0.15); color: #EAB308; border-left: 3px solid #EAB308; }
        .card { background: #1a1a1a; border: 1px solid #2a2a2a; border-radius: 16px; }
        .antrian-card { background: #1a1a1a; border: 1px solid #2a2a2a; border-radius: 12px; transition: all 0.3s; }
        .antrian-card:hover { border-color: #EAB308; }
        .antrian-card.active-now { border-color: #22c55e; background: rgba(34,197,94,0.05); }
        .badge { padding: 0.25rem 0.75rem; border-radius: 999px; font-size: 0.75rem; font-weight: 600; }
        .pulse { animation: pulse 2s infinite; }
        @keyframes pulse { 0%, 100% { opacity: 1; } 50% { opacity: 0.5; } }
        .select-status { background: #222; border: 1px solid #333; border-radius: 8px; color: white; padding: 0.4rem 0.7rem; font-size: 0.8rem; outline: none; cursor: pointer; }
        .select-status:focus { border-color: #EAB308; }
    </style>
</head>
<body style="background:#0e0e0e; color:white;">

<div class="flex min-h-screen">

    <aside class="w-64 shrink-0 flex flex-col" style="background:#111; border-right: 1px solid #222;">
        <div class="px-6 py-6 border-b border-gray-800">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 bg-[#EAB308] rounded-lg flex items-center justify-center shrink-0">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#000" stroke-width="2.5"><path d="M6 3v18M18 3v18M6 7h12M6 17h12"/></svg>
                </div>
                <div>
                    <p class="text-white font-bold font-display text-sm">Mr. Brokker</p>
                    <p class="text-gray-500 text-xs">Panel Admin</p>
                </div>
            </div>
        </div>
        <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto">
            <p class="text-gray-600 text-xs font-semibold uppercase tracking-wider px-3 mb-2">Menu Utama</p>

            <a href="{{ route('admin.dashboard') }}"
               class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }} flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('admin.dashboard') ? 'text-[#EAB308]' : 'text-gray-400' }}">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/></svg>
                Dashboard
            </a>

            <a href="{{ route('admin.reservations') }}"
               class="sidebar-link {{ request()->routeIs('admin.reservations') ? 'active' : '' }} flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('admin.reservations') ? 'text-[#EAB308]' : 'text-gray-400' }}">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
                Reservasi
            </a>

            <a href="{{ route('admin.antrian') }}"
               class="sidebar-link {{ request()->routeIs('admin.antrian') ? 'active' : '' }} flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('admin.antrian') ? 'text-[#EAB308]' : 'text-gray-400' }}">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                Antrian
            </a>

            <p class="text-gray-600 text-xs font-semibold uppercase tracking-wider px-3 mt-4 mb-2">Manajemen</p>

            <a href="{{ route('admin.layanan') }}"
               class="sidebar-link {{ request()->routeIs('admin.layanan') ? 'active' : '' }} flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('admin.layanan') ? 'text-[#EAB308]' : 'text-gray-400' }}">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/></svg>
                Layanan
            </a>

            <a href="{{ route('admin.jadwal') }}"
               class="sidebar-link {{ request()->routeIs('admin.jadwal') ? 'active' : '' }} flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('admin.jadwal') ? 'text-[#EAB308]' : 'text-gray-400' }}">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18M12 14v4M16 16H8"/></svg>
               Jadwal Buka
            </a>

            <a href="{{ route('admin.laporan') }}"
               class="sidebar-link {{ request()->routeIs('admin.laporan') ? 'active' : '' }} flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('admin.laporan') ? 'text-[#EAB308]' : 'text-gray-400' }}">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>
                Laporan
            </a>

            <a href="{{ route('admin.status') }}"
               class="sidebar-link {{ request()->routeIs('admin.status') ? 'active' : '' }} flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('admin.status') ? 'text-[#EAB308]' : 'text-gray-400' }}">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                Status
            </a>

            <a href="{{ route('admin.galeri') }}"
               class="sidebar-link {{ request()->routeIs('admin.galeri') ? 'active' : '' }} flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('admin.galeri') ? 'text-[#EAB308]' : 'text-gray-400' }}">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21,15 16,10 5,21"/></svg>
                Galeri
            </a>
        </nav>
        <div class="px-4 py-4 border-t border-gray-800">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-full bg-[#EAB308] flex items-center justify-center text-black font-bold text-sm">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-white text-sm font-medium truncate">{{ auth()->user()->name }}</p>
                    <p class="text-gray-500 text-xs truncate">{{ auth()->user()->email }}</p>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}" class="mt-3">
                @csrf
                <button type="submit" class="w-full text-left text-gray-500 text-xs hover:text-red-400 transition flex items-center gap-2">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16,17 21,12 16,7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                    Keluar
                </button>
            </form>
        </div>
    </aside>

    <main class="flex-1 overflow-auto">
        <div class="px-8 py-6 border-b border-gray-800 flex items-center justify-between" style="background:#111;">
            <div>
                <h1 class="text-xl font-bold font-display text-white">Monitoring Antrian</h1>
                <p class="text-gray-500 text-sm mt-0.5">
                    Antrian hari ini — {{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM Y') }}
                </p>
            </div>
            <div class="flex items-center gap-2">
                <div class="w-2 h-2 rounded-full bg-green-400 pulse"></div>
                <span class="text-green-400 text-sm font-medium">Live</span>
                <span class="text-gray-600 text-xs ml-2" id="lastUpdate"></span>
            </div>
        </div>

        <div class="px-8 py-8">

            @if(session('success'))
            <div class="mb-6 px-4 py-3 rounded-xl text-sm font-medium flex items-center gap-2" style="background:rgba(34,197,94,0.1);border:1px solid rgba(34,197,94,0.3);color:#22c55e;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22,4 12,14.01 9,11.01"/></svg>
                {{ session('success') }}
            </div>
            @endif

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
                <div class="card p-5 text-center">
                    <p class="text-3xl font-bold text-white font-display">{{ $totalHariIni }}</p>
                    <p class="text-gray-500 text-xs mt-1">Total Hari Ini</p>
                </div>
                <div class="card p-5 text-center">
                    <p class="text-3xl font-bold font-display" style="color:#EAB308;">{{ $pending }}</p>
                    <p class="text-gray-500 text-xs mt-1">⏳ Menunggu</p>
                </div>
                <div class="card p-5 text-center">
                    <p class="text-3xl font-bold font-display" style="color:#22c55e;">{{ $confirmed }}</p>
                    <p class="text-gray-500 text-xs mt-1">✅ Dikonfirmasi</p>
                </div>
                <div class="card p-5 text-center">
                    <p class="text-3xl font-bold font-display" style="color:#ef4444;">{{ $cancelled }}</p>
                    <p class="text-gray-500 text-xs mt-1">❌ Dibatalkan</p>
                </div>
            </div>

            @if($antrian->isEmpty())
                <div class="card p-16 text-center text-gray-500">
                    <svg width="56" height="56" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="mx-auto mb-4 opacity-30"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    <p class="text-lg font-medium">Tidak ada antrian hari ini</p>
                    <p class="text-sm mt-1">Antrian akan muncul di sini secara real-time</p>
                </div>
            @else
            <div class="space-y-4">
                @foreach($antrian as $i => $r)
                @php
    // Set zona waktu eksekusi agar seragam (Ganti Asia/Makassar jika ingin WITA)
    $timezone = 'Asia/Makassar'; 
    
    $jamReservasi = \Carbon\Carbon::parse($r->jam, $timezone);
    $sekarang = \Carbon\Carbon::now($timezone);
    $isNow = $sekarang->format('H') == $jamReservasi->format('H');

    // Membersihkan format nomor WA
    $phone = preg_replace('/[^0-9]/', '', $r->whatsapp);
    if (str_starts_with($phone, '0')) {
        $phone = '62' . substr($phone, 1);
    }
    
    $waUrl = "https://wa.me/{$phone}?text=" . urlencode("Halo {$r->nama}, kami dari Mr. Brokker Barbershop ingin mengonfirmasi antrian Anda pada jam {$r->jam}.");

    // Satukan tanggal hari ini dengan jam booking pelanggan menggunakan timezone yang dikunci
    $waktuBookingFull = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $r->tanggal . ' ' . $r->jam, $timezone);
    
    // Hitung selisih menit murni dari sekarang ke waktu booking
    $selisihMenitMurni = $sekarang->diffInMinutes($waktuBookingFull, false);
    $selisihJamAbsolut = ceil(abs($selisihMenitMurni) / 60);

    // JIKA sekarang LEBIH KECIL (LT) dari waktu booking, berarti belum lewat
    if ($sekarang->lt($waktuBookingFull)) {
        $teksTombol = "Kirim Pengingat ({$selisihJamAbsolut} Jam Lagi)";
        $pesanWhatsapp = "Halo {$r->nama}, ini pengingat otomatis dari Mr. Brokker Barbershop. Jadwal booking Anda adalah hari ini pada jam *{$r->jam}*.\n\n" .
                         "*Catatan Penting:* Batas maksimal keterlambatan kehadiran adalah *5 menit*. Jika melewati batas keterlambatan tersebut, maka booking Anda akan dianggap *HANGUS* oleh sistem. Terima kasih.";
    } else {
        // Jika sudah sama atau melewati waktu booking
        $teksTombol = "Peringatan Keterlambatan";
        $pesanWhatsapp = "Halo {$r->nama}, jadwal booking Anda pada jam *{$r->jam}* saat ini terpantau sudah berjalan.\n\n" .
                         "Kami mengingatkan kembali bahwa batas maksimal toleransi keterlambatan adalah *5 menit*. Jika Anda melewati batas waktu tersebut dan belum melakukan check-in di toko, maka booking Anda otomatis dianggap *HANGUS*. Terima kasih.";
    }

    $waUrlReminder = "https://wa.me/{$phone}?text=" . urlencode($pesanWhatsapp);
@endphp 
                <div class="antrian-card p-5 {{ $isNow && $r->status === 'confirmed' ? 'active-now' : '' }}">
                    <div class="flex items-center justify-between flex-wrap gap-4">

                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-xl flex items-center justify-center font-bold text-lg font-display shrink-0"
                                style="{{ $isNow && $r->status === 'confirmed' ? 'background:rgba(34,197,94,0.2);color:#22c55e;' : 'background:rgba(234,179,8,0.15);color:#EAB308;' }}">
                                {{ $i + 1 }}
                            </div>
                            <div>
                                <div class="flex items-center gap-2">
                                    <p class="text-white font-semibold text-base">{{ $r->nama }}</p>
                                    @if($isNow && $r->status === 'confirmed')
                                        <span class="badge pulse" style="background:rgba(34,197,94,0.2);color:#22c55e;">🟢 Sedang Dilayani</span>
                                    @endif
                                </div>
                                <p class="text-gray-400 text-sm mt-0.5">{{ $r->layanan }}</p>
                                
                                {{-- AREA TOMBOL CHAT WHATSAPP --}}
                                @if($r->whatsapp)
                                    <div class="mt-2 flex items-center gap-2 flex-wrap">
                                        <!-- Tombol Konfirmasi Utama -->
                                        <a href="{{ $waUrl }}" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg bg-green-500/10 hover:bg-green-500/20 text-green-500 text-[11px] font-bold transition border border-green-500/20">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                                            Chat WhatsApp
                                        </a>

                                        <!-- Tombol Pengingat / Peringatan Dinamis (Hanya Muncul di Status Terkonfirmasi) -->
                                        @if($r->status === 'confirmed')
                                            <a href="{{ $waUrlReminder }}" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg bg-amber-500/20 hover:bg-amber-500/30 text-amber-500 text-[11px] font-bold transition border border-amber-500/30">
                                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                                                🔔 {{ $teksTombol }}
                                            </a>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="flex items-center gap-6">
                            <div class="text-center">
                                <p class="text-[#EAB308] text-xl font-bold font-display">{{ \Carbon\Carbon::parse($r->jam)->format('H:i') }}</p>
                                <p class="text-gray-500 text-xs">WITA</p>
                            </div>

                            <div>
                                @if($r->status === 'confirmed')
                                    <span class="badge" style="background:rgba(34,197,94,0.15);color:#22c55e;">✅ Dikonfirmasi</span>
                                @elseif($r->status === 'cancelled')
                                    <span class="badge" style="background:rgba(239,68,68,0.15);color:#ef4444;">❌ Dibatalkan</span>
                                @else
                                    <span class="badge" style="background:rgba(234,179,8,0.15);color:#EAB308;">⏳ Menunggu</span>
                                @endif
                            </div>

                            <form action="{{ route('admin.reservations.status', $r->id) }}" method="POST">
                                @csrf @method('PUT')
                                <select name="status" class="select-status" onchange="this.form.submit()">
                                    <option value="pending" {{ $r->status === 'pending' ? 'selected' : '' }}>⏳ Menunggu</option>
                                    <option value="confirmed" {{ $r->status === 'confirmed' ? 'selected' : '' }}>✅ Konfirmasi</option>
                                    <option value="cancelled" {{ $r->status === 'cancelled' ? 'selected' : '' }}>❌ Batalkan</option>
                                </select>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @endif

            @if($mendatang->isNotEmpty())
            <div class="mt-10">
                <h2 class="text-lg font-bold font-display mb-4 text-gray-300">📅 Reservasi Mendatang</h2>
                <div class="card overflow-hidden">
                    <table class="w-full text-sm text-left">
                        <thead>
                            <tr class="border-b border-gray-800">
                                <th class="text-gray-500 font-medium py-3 px-5">Pelanggan</th>
                                <th class="text-gray-500 font-medium py-3 px-5">Layanan</th>
                                <th class="text-gray-500 font-medium py-3 px-5">Tanggal</th>
                                <th class="text-gray-500 font-medium py-3 px-5">Jam</th>
                                <th class="text-gray-500 font-medium py-3 px-5">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-800">
                            @foreach($mendatang as $r)
                            @php
                                $phoneMendatang = preg_replace('/[^0-9]/', '', $r->whatsapp);
                                if (str_starts_with($phoneMendatang, '0')) { $phoneMendatang = '62' . substr($phoneMendatang, 1); }
                                
                                // Sinkronisasi aturan hangus 5 menit pada tabel reservasi mendatang
                                $pesanMendatang = "Halo {$r->nama}, kami dari Mr. Brokker mengonfirmasi reservasi Anda tanggal {$r->tanggal} jam {$r->jam}.\n\n" .
                                                  "*Catatan Penting:* Batas maksimal keterlambatan kehadiran adalah *5 menit*. Jika melewati batas keterlambatan tersebut, maka booking Anda akan dianggap *HANGUS* oleh sistem.";
                                $waUrlMendatang = "https://wa.me/{$phoneMendatang}?text=" . urlencode($pesanMendatang);
                            @endphp
                            <tr>
                                <td class="py-3 px-5 text-white font-medium">{{ $r->nama }}</td>
                                <td class="py-3 px-5 text-gray-400">{{ $r->layanan }}</td>
                                <td class="py-3 px-5 text-gray-400">{{ \Carbon\Carbon::parse($r->tanggal)->format('d M Y') }}</td>
                                <td class="py-3 px-5 text-[#EAB308] font-semibold">{{ \Carbon\Carbon::parse($r->jam)->format('H:i') }} WITA</td>
                                <td class="py-3 px-5">
                                    <a href="{{ $waUrlMendatang }}" target="_blank" class="text-green-500 hover:text-green-400 flex items-center gap-1 font-bold text-xs">
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                                        Chat
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif

        </div>
    </main>
</div>

<script>
    function updateTime() {
        const now = new Date();
        document.getElementById('lastUpdate').textContent = 'Update: ' + now.toLocaleTimeString('id-ID');
    }
    updateTime();

    setInterval(() => {
        window.location.reload();
    }, 60000);
</script>

</body>
</html>