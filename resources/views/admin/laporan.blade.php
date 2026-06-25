<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Pendapatan — Mr. Brokker</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.0/chart.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.8.2/jspdf.plugin.autotable.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'DM Sans', sans-serif; }
        .font-display { font-family: 'Playfair Display', serif; }
        .sidebar-link { transition: all 0.2s; }
        .sidebar-link:hover, .sidebar-link.active { background: rgba(234,179,8,0.15); color: #EAB308; border-left: 3px solid #EAB308; }
        .card  { background: #1a1a1a; border: 1px solid #2a2a2a; border-radius: 16px; }
        .stat-card { background: #1a1a1a; border: 1px solid #2a2a2a; border-radius: 16px; transition: all 0.3s; }
        .stat-card:hover { border-color: #EAB308; transform: translateY(-2px); }
        .btn-gold  { background:#EAB308; color:#000; border:none; border-radius:8px; padding:0.5rem 1.1rem; font-size:0.875rem; font-weight:600; cursor:pointer; display:flex; align-items:center; gap:0.4rem; transition:all 0.2s; white-space:nowrap; }
        .btn-gold:hover  { background:#ca9e06; }
        .btn-ghost { background:transparent; color:#EAB308; border:1px solid #EAB308; border-radius:8px; padding:0.45rem 1rem; font-size:0.875rem; font-weight:600; cursor:pointer; display:flex; align-items:center; gap:0.4rem; transition:all 0.2s; white-space:nowrap; }
        .btn-ghost:hover { background:rgba(234,179,8,0.1); }
        .date-wrap { display:flex; align-items:center; gap:0.5rem; background:#1a1a1a; border:1px solid #333; border-radius:8px; padding:0.45rem 0.9rem; min-width:145px; cursor:pointer; }
        .date-wrap:focus-within { border-color:#EAB308; }
        .date-wrap input { background:transparent; border:none; outline:none; color:white; font-size:0.875rem; cursor:pointer; width:100%; }
        .date-wrap input::placeholder { color:#555; }
        .badge-period { background:rgba(234,179,8,.15); border:1px solid rgba(234,179,8,.4); color:#EAB308; border-radius:6px; padding:0.2rem 0.65rem; font-size:0.75rem; font-weight:600; }

        .flatpickr-calendar { background:#1a1a1a !important; border:1px solid #EAB308 !important; border-radius:12px !important; box-shadow:0 8px 32px rgba(234,179,8,.25) !important; font-family:'DM Sans',sans-serif !important; width:280px !important; }
        .flatpickr-months { background:#111 !important; border-radius:12px 12px 0 0 !important; padding:8px 10px !important; display:flex !important; align-items:center !important; justify-content:center !important; gap:8px !important; }
        .flatpickr-prev-month, .flatpickr-next-month { display:none !important; }
        .flatpickr-month { color:#EAB308 !important; fill:#EAB308 !important; height:36px !important; flex:none !important; width:auto !important; }
        .flatpickr-current-month { display:flex !important; align-items:center !important; justify-content:center !important; gap:8px !important; padding:0 !important; width:auto !important; font-size:13px !important; position:static !important; left:auto !important; }
        .fp-month-block { display:flex; align-items:center; gap:4px; background:rgba(234,179,8,0.1); border:1px solid rgba(234,179,8,0.35); border-radius:7px; padding:3px 8px; }
        .fp-month-block .fp-nav { color:#EAB308; font-size:14px; font-weight:700; cursor:pointer; line-height:1; padding:0 2px; user-select:none; }
        .fp-month-block .fp-nav:hover { color:#fff; }
        .flatpickr-current-month .cur-month { color:#EAB308 !important; font-weight:700 !important; font-size:13px !important; margin:0 !important; padding:0 !important; }
        .flatpickr-current-month .numInputWrapper { display:none !important; }
        .fp-year-block { display:flex; align-items:center; gap:4px; background:rgba(234,179,8,0.1); border:1px solid rgba(234,179,8,0.35); border-radius:7px; padding:3px 8px; }
        .fp-year-block .fp-nav { color:#EAB308; font-size:14px; font-weight:700; cursor:pointer; line-height:1; padding:0 2px; user-select:none; }
        .fp-year-block .fp-nav:hover { color:#fff; }
        .fp-year-block .fp-year-label { color:#EAB308; font-weight:700; font-size:13px; min-width:36px; text-align:center; }
        .flatpickr-weekdays { background:#111 !important; padding:4px 0 !important; }
        .flatpickr-weekday { color:#EAB308 !important; font-size:11px !important; font-weight:600 !important; }
        .flatpickr-days { border-top:1px solid #2a2a2a !important; }
        .dayContainer { padding:6px !important; }
        .flatpickr-day { color:#ccc !important; border-radius:6px !important; font-size:12px !important; height:32px !important; line-height:32px !important; max-width:32px !important; border:none !important; }
        .flatpickr-day:hover { background:rgba(234,179,8,0.2) !important; color:#EAB308 !important; border-color:transparent !important; }
        .flatpickr-day.selected, .flatpickr-day.startRange, .flatpickr-day.endRange { background:#EAB308 !important; border-color:#EAB308 !important; color:#000 !important; font-weight:700 !important; }
        .flatpickr-day.inRange { background:rgba(234,179,8,0.15) !important; border-color:transparent !important; color:#EAB308 !important; box-shadow:none !important; }
        .flatpickr-day.prevMonthDay, .flatpickr-day.nextMonthDay { visibility:hidden !important; pointer-events:none !important; }
        .flatpickr-day.today { border:1px solid rgba(234,179,8,0.5) !important; color:#EAB308 !important; }
        .flatpickr-day.today:hover { background:rgba(234,179,8,0.2) !important; }
    </style>
</head>
<body style="background:#0e0e0e;color:white;">
<div class="flex min-h-screen">

    <aside class="w-64 shrink-0 flex flex-col" style="background:#111;border-right:1px solid #222;">
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
            <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }} flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('admin.dashboard') ? 'text-[#EAB308]' : 'text-gray-400' }}">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/></svg>
                Dashboard
            </a>
            <a href="{{ route('admin.reservations') }}" class="sidebar-link {{ request()->routeIs('admin.reservations') ? 'active' : '' }} flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('admin.reservations') ? 'text-[#EAB308]' : 'text-gray-400' }}">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
                Reservasi
            </a>
            <a href="{{ route('admin.antrian') }}" class="sidebar-link {{ request()->routeIs('admin.antrian') ? 'active' : '' }} flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('admin.antrian') ? 'text-[#EAB308]' : 'text-gray-400' }}">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                Antrian
            </a>
            <p class="text-gray-600 text-xs font-semibold uppercase tracking-wider px-3 mt-4 mb-2">Manajemen</p>
            <a href="{{ route('admin.layanan') }}" class="sidebar-link {{ request()->routeIs('admin.layanan') ? 'active' : '' }} flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('admin.layanan') ? 'text-[#EAB308]' : 'text-gray-400' }}">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/></svg>
                Layanan
            </a>
            <a href="{{ route('admin.jadwal') }}" class="sidebar-link {{ request()->routeIs('admin.jadwal') ? 'active' : '' }} flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('admin.jadwal') ? 'text-[#EAB308]' : 'text-gray-400' }}">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18M12 14v4M16 16H8"/></svg>
                Jadwal Buka
            </a>
            <a href="{{ route('admin.laporan') }}" class="sidebar-link {{ request()->routeIs('admin.laporan') ? 'active' : '' }} flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('admin.laporan') ? 'text-[#EAB308]' : 'text-gray-400' }}">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>
                Laporan
            </a>
            <a href="{{ route('admin.status') }}" class="sidebar-link {{ request()->routeIs('admin.status') ? 'active' : '' }} flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('admin.status') ? 'text-[#EAB308]' : 'text-gray-400' }}">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                Status
            </a>
            <a href="{{ route('admin.galeri') }}" class="sidebar-link {{ request()->routeIs('admin.galeri') ? 'active' : '' }} flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('admin.galeri') ? 'text-[#EAB308]' : 'text-gray-400' }}">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21,15 16,10 5,21"/></svg>
                Galeri
            </a>
        </nav>
        <div class="px-4 py-4 border-t border-gray-800">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-full bg-[#EAB308] flex items-center justify-center text-black font-bold text-sm">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
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
        <div class="px-8 py-5 border-b border-gray-800 flex flex-wrap items-center justify-between gap-4" style="background:#111;">
            <div>
                <h1 class="text-xl font-bold font-display text-white">Laporan Pendapatan</h1>
                <p class="text-gray-500 text-sm mt-0.5">Rekap pendapatan berdasarkan reservasi yang selesai</p>
            </div>
            <form method="GET" action="{{ route('admin.laporan') }}" id="formFilter" class="flex flex-wrap items-center gap-3">
                <div class="date-wrap" onclick="document.getElementById('tglDari').focus()">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#EAB308" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
                    <input type="text" id="tglDari" name="dari" value="{{ $dari ?? '' }}" placeholder="Dari tanggal" readonly autocomplete="off">
                </div>
                <div class="date-wrap" onclick="document.getElementById('tglSampai').focus()">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#EAB308" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
                    <input type="text" id="tglSampai" name="sampai" value="{{ $sampai ?? '' }}" placeholder="Sampai tanggal" readonly autocomplete="off">
                </div>
                <button type="submit" class="btn-ghost">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    Filter
                </button>
                @if($dari)
                <a href="{{ route('admin.laporan') }}" class="text-gray-500 text-xs hover:text-red-400 transition flex items-center gap-1">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                    Reset
                </a>
                @endif
                <button type="button" class="btn-gold" onclick="exportPDF()">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7,10 12,15 17,10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                    Export PDF
                </button>
            </form>
        </div>

        @if($dari && $sampai)
        <div class="px-8 pt-5 flex items-center gap-2">
            <span class="text-gray-500 text-sm">Periode:</span>
            <span class="badge-period">
                {{ \Carbon\Carbon::parse($dari)->translatedFormat('d F Y') }} &nbsp;→&nbsp; {{ \Carbon\Carbon::parse($sampai)->translatedFormat('d F Y') }}
            </span>
        </div>
        @endif

        <div class="px-8 py-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-8">
                <div class="stat-card p-6">
                    <div class="flex items-center justify-between mb-3">
                        <p class="text-gray-400 text-sm">Total Pendapatan</p>
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background:rgba(234,179,8,.15);">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#EAB308" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                        </div>
                    </div>
                    <p class="text-3xl font-bold text-[#EAB308] font-display">Rp{{ number_format($totalPendapatan,0,',','.') }}</p>
                    <p class="text-gray-500 text-xs mt-1">
                        @if($dari && $sampai)
                            {{ \Carbon\Carbon::parse($dari)->format('d M') }} – {{ \Carbon\Carbon::parse($sampai)->format('d M Y') }}
                        @else
                            {{ \Carbon\Carbon::create()->month($bulan)->locale('id')->monthName }} {{ $tahun }}
                        @endif
                    </p>
                </div>
                <div class="stat-card p-6">
                    <div class="flex items-center justify-between mb-3">
                        <p class="text-gray-400 text-sm">Total Reservasi Selesai</p>
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background:rgba(34,197,94,.15);">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#22c55e" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22,4 12,14.01 9,11.01"/></svg>
                        </div>
                    </div>
                    <p class="text-3xl font-bold text-white font-display">{{ $totalReservasi }}</p>
                    <p class="text-gray-500 text-xs mt-1">Reservasi selesai</p>
                </div>
                <div class="stat-card p-6">
                    <div class="flex items-center justify-between mb-3">
                        <p class="text-gray-400 text-sm">Rata-rata per Reservasi</p>
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background:rgba(139,92,246,.15);">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#8b5cf6" stroke-width="2"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>
                        </div>
                    </div>
                    <p class="text-3xl font-bold text-white font-display">Rp{{ $totalReservasi > 0 ? number_format($totalPendapatan/$totalReservasi,0,',','.') : '0' }}</p>
                    <p class="text-gray-500 text-xs mt-1">Per transaksi</p>
                </div>
            </div>

            @if(isset($grafikHarian) && count($grafikHarian) > 0)
            <div class="card p-6 mb-8">
                <h2 class="text-base font-bold font-display mb-6">Grafik Pendapatan Harian</h2>
                <canvas id="grafikPendapatan" height="80"></canvas>
            </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div class="card p-6">
                    <h2 class="text-base font-bold font-display mb-4">Pendapatan per Layanan</h2>
                    @if($perLayanan->isEmpty())
                        <p class="text-gray-500 text-sm text-center py-8">Belum ada data</p>
                    @else
                    <div class="space-y-3">
                        @foreach($perLayanan as $l)
                        <div class="flex items-center justify-between">
                            <div class="text-sm text-white font-medium">{{ $l->service }}</div>
                            <div class="text-right">
                                <p class="text-[#EAB308] font-semibold text-sm">Rp{{ number_format($l->total,0,',','.') }}</p>
                                <p class="text-gray-500 text-xs">{{ $l->jumlah }}x transaksi</p>
                            </div>
                        </div>
                        <div class="w-full rounded-full h-1.5" style="background:#2a2a2a;">
                            <div class="h-1.5 rounded-full" style="background:#EAB308;width:{{ $totalPendapatan > 0 ? ($l->total/$totalPendapatan*100) : 0 }}%"></div>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
                <div class="card p-6">
                    <h2 class="text-base font-bold font-display mb-4">Transaksi dalam Periode</h2>
                    @if($detailTransaksi->isEmpty())
                        <p class="text-gray-500 text-sm text-center py-8">Belum ada transaksi</p>
                    @else
                    <div class="space-y-3 max-h-72 overflow-y-auto pr-1">
                        @foreach($detailTransaksi as $t)
                        <div class="flex items-center justify-between py-2 border-b border-gray-800 last:border-0">
                            <div>
                                <p class="text-white text-sm font-medium">{{ $t->name }}</p>
                                <p class="text-gray-500 text-xs">{{ $t->service }} · {{ \Carbon\Carbon::parse($t->date)->translatedFormat('d M Y') }}</p>
                            </div>
                            <p class="text-[#EAB308] font-semibold text-sm">Rp{{ number_format($t->harga??0,0,',','.') }}</p>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </main>
</div>

<script>
const laporanData = {
    dari:            "{{ $dari ?? '' }}",
    sampai:          "{{ $sampai ?? '' }}",
    bulan:           {{ $bulan }},
    tahun:           {{ $tahun }},
    totalPendapatan: {{ $totalPendapatan }},
    totalReservasi:  {{ $totalReservasi }},
    grafikHarian:    @json($grafikHarian),
    perLayanan:      @json($perLayanan),
    detailTransaksi: @json($detailTransaksi),
};

/* ── Logo base64 ── */
const LOGO_B64 = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAoAAAAEhCAYAAADvZRH1AAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAAFiUAABYlAUlSJPAAAP+lSURBVHhe7J1nnBTF1oef6jAzG1hglxwEBSWrmEBFDNcses3e13jNOWBEVFAQzIKKggFBGetVEcSMAQFRFJUgOYOkZXdZNsx0qPdD9czOzO7CgoCA9fhrme1QXV3d0/WfU3XOEb7vS6pBymo3JRBCpK2RwVId8f3Tj4tTcXz8/IZh4Pt+2n7JiErlVa5X1ddTeb+/Wv8dS/I1Vb4WRcp1V7NPxdrU6xfxVcmIyqu2DIGQ6l9ZqTo7uv2rOp/cZPlCmIk2VUfLRBFVHWUkrfUFla5ZQNAeNadid5lUetKnpPKSzyeR1Z6smtXxGqavVHUQVbVfErLi2MolVD5nSttIiTCMoK3jO4qKtpcy5ZmPf45vT/8+xPdPX59K6vVUnLv6Y0TSNabgy6DpKral3Iu099Gm61WZmnz3q1tPFecHdRlptaq4Mik3e87UMlP3lTK5KZIbAgSSosIiVq1exbx5cygsLFTLhg34vofneixfvjxxVFlZORs2bKCoqAjTtBKnyqmdQ1ZWNtnZ2UgBlmWRl5dHJBIhHA6TkZFBgwYNaNqkKU2bNqFli5YV9Ugi/Tu6/Uh93mpGvHLx92gq8bqrTanf96r2r0zl51ndvxodvBm29np32A3Z5tSk3Sr2kJiGID8/n/z8daxcsZL89fnkr8unqLAQ3/NxfY8NxcWUlJSwsaSE8rIojuPgOA6lpaWJAjMiEUK2jR0KkZmRQWZmJpmZmWRkRgiHQ9h2CPFXBWBlQVF9BwPxpzP9mGQqjo+f3xAGvvQ38dxUlJn4alSqVzXXU2m/v1r/VGq+59axuRcyaV+36l5sFZcsEWkNnX7IJlqnhlS0YeWytm37b57NnK8KBCYgkTKojlSfq6uZCDpRGXSu6fdApLT/ponvllxG8rEpRUu1IvX+yypbnfRjk6mmzVUdqi9PUXFsddcYv34Z/yNASomREIAV66oj+flP3y++rbrvSCoVPzb9TV6bunSBCERg+rbg2GoEIGn1rFndKvgrxyaTcoUpxQjUcx7sEb+c+NYqzpne7slUtX8CCSLxgKh/43/5vofn+RSsX584t+t6lJSUUFJSghAGBM9PKBwiKyuLzMxMXM8jHA5Tu3ZtDMMIjkwj+N6mraq8crsh0+9ADRAVFUyrf/wdU/F3RfmC6r+DqSSVv81Jvd7074OVVPP+qQlbd9S2ZVPfidQnXn0SIvihGqxRnwTS95QQB0pLS4k5MWIxh7LScnzfx3VdotFoosBIOIxpmpimiW1bZEQy1A+hiI1hmGAYf00AyviXOqWVN/dA1+RmqhdwugCsttTgAaposKpfNunXs/3qH1DFy2VbU5NOQFLzKqs6b8rauq2oeBlXrts2bP8as2XXKzCRypamSBKAVWEkCwCqqP4mjk0n+fj0VhJUfsFXvX/111t1PSp3nhVlbdn9qlT+Jq69KgEYXy/TrH+kPf/xY0Q1Fr+qjq+g4po28dZJIGRF+yS3vzoHiauO34v064lTfX2qpibf/ZqQ8oxUauuUPxP3SlRzzvTj06nqmDi+72KaNiDxfQ/f97EsGyl9PM+rcE7DMEAYFSpCysT9Su/eO+eq+nbHRdtVdcrV0L4veqRzOX8sV0oJRd4oQAAAABJRU5ErkJggg==';
</script>

<script>
const NAMA_BULAN_ID = ['Januari','Februari','Maret','April','Mei','Juni',
                       'Juli','Agustus','September','Oktober','November','Desember'];

function buildMonthNav(fp) {
    const cal = fp.calendarContainer;
    const month = cal.querySelector('.cur-month');
    if (!month || month.parentElement.classList.contains('fp-month-block')) return;
    const wrap = document.createElement('span'); wrap.className = 'fp-month-block';
    const prev = document.createElement('span'); prev.className = 'fp-nav'; prev.textContent = '‹'; prev.onclick = () => fp.changeMonth(-1);
    const next = document.createElement('span'); next.className = 'fp-nav'; next.textContent = '›'; next.onclick = () => fp.changeMonth(1);
    month.parentNode.insertBefore(wrap, month);
    wrap.appendChild(prev); wrap.appendChild(month); wrap.appendChild(next);
}

function buildYearNav(fp) {
    const cal = fp.calendarContainer;
    if (cal.querySelector('.fp-year-block')) return;
    const currentMonth = cal.querySelector('.flatpickr-current-month'); if (!currentMonth) return;
    const wrap = document.createElement('span'); wrap.className = 'fp-year-block';
    const prev = document.createElement('span'); prev.className = 'fp-nav'; prev.textContent = '‹'; prev.onclick = () => { fp.changeYear(fp.currentYear - 1); updateYearLabel(fp); };
    const label = document.createElement('span'); label.className = 'fp-year-label'; label.textContent = fp.currentYear;
    const next = document.createElement('span'); next.className = 'fp-nav'; next.textContent = '›'; next.onclick = () => { fp.changeYear(fp.currentYear + 1); updateYearLabel(fp); };
    wrap.appendChild(prev); wrap.appendChild(label); wrap.appendChild(next);
    currentMonth.appendChild(wrap);
}

function updateYearLabel(fp) { const l = fp.calendarContainer.querySelector('.fp-year-label'); if (l) l.textContent = fp.currentYear; }
function translateMonth(fp) { const m = fp.calendarContainer.querySelector('.cur-month'); if (m) m.textContent = NAMA_BULAN_ID[fp.currentMonth]; }

const fpOpts = {
    dateFormat:'Y-m-d', altInput:true, altFormat:'d M Y', showMonths:1, allowInput:false,
    locale:{ firstDayOfWeek:1 },
    onReady:       function(_d,_s,fp){ buildMonthNav(fp); translateMonth(fp); buildYearNav(fp); },
    onMonthChange: function(_d,_s,fp){ translateMonth(fp); updateYearLabel(fp); },
    onYearChange:  function(_d,_s,fp){ translateMonth(fp); updateYearLabel(fp); },
};

const fpDari = flatpickr("#tglDari", {
    ...fpOpts, defaultDate: laporanData.dari || null,
    onChange: function(dates,_s,fp){ if(dates[0]) fpSampai.set('minDate',dates[0]); translateMonth(fp); updateYearLabel(fp); }
});
const fpSampai = flatpickr("#tglSampai", {
    ...fpOpts, defaultDate: laporanData.sampai || null, minDate: laporanData.dari || null,
    onChange: function(dates,_s,fp){ if(dates[0]) fpDari.set('maxDate',dates[0]); translateMonth(fp); updateYearLabel(fp); }
});
</script>

@if(isset($grafikHarian) && count($grafikHarian) > 0)
<script>
new Chart(document.getElementById('grafikPendapatan').getContext('2d'), {
    type:'bar',
    data:{
        labels: laporanData.grafikHarian.map(d=>{ const dt=new Date(d.tanggal); return dt.toLocaleDateString('id-ID',{day:'2-digit',month:'short'}); }),
        datasets:[{ label:'Pendapatan (Rp)', data:laporanData.grafikHarian.map(d=>d.total), backgroundColor:'rgba(234,179,8,0.3)', borderColor:'#EAB308', borderWidth:2, borderRadius:6 }]
    },
    options:{
        responsive:true,
        plugins:{ legend:{display:false}, tooltip:{callbacks:{label:c=>'Rp '+c.raw.toLocaleString('id-ID')}} },
        scales:{
            x:{grid:{color:'rgba(255,255,255,0.05)'},ticks:{color:'#6b7280',font:{size:11}}},
            y:{grid:{color:'rgba(255,255,255,0.05)'},ticks:{color:'#6b7280',font:{size:11},callback:v=>'Rp '+v.toLocaleString('id-ID')}}
        }
    }
});
</script>
@endif

<script>
const BULAN = ['Januari','Februari','Maret','April','Mei','Juni',
               'Juli','Agustus','September','Oktober','November','Desember'];

function formatRp(n){ return 'Rp '+Number(n).toLocaleString('id-ID'); }
function tglID(str){ if(!str) return '-'; const d=new Date(str); return d.getDate()+' '+BULAN[d.getMonth()]+' '+d.getFullYear(); }

function exportPDF() {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF({ orientation:'portrait', unit:'mm', format:'a4' });
    const pw  = doc.internal.pageSize.getWidth();
    const ph  = doc.internal.pageSize.getHeight();
    const mg  = 14, cw = pw - mg * 2;

    const isRange = laporanData.dari !== '' && laporanData.sampai !== '';
    const periodeLabel = isRange
        ? tglID(laporanData.dari) + '  s/d  ' + tglID(laporanData.sampai)
        : 'Bulan ' + BULAN[laporanData.bulan-1] + ' ' + laporanData.tahun;

    /* ═══════════════════════════════════════════════
       HEADER — latar hitam penuh
    ═══════════════════════════════════════════════ */
    doc.setFillColor(15,15,15);
    doc.rect(0, 0, pw, 52, 'F');

    /* Garis emas tipis di atas */
    doc.setDrawColor(234,179,8); doc.setLineWidth(1.2);
    doc.line(0, 0, pw, 0);

    /* Logo */
    try { doc.addImage(LOGO_B64, 'PNG', mg, 6, 26, 40); } catch(e) {}

    /* Nama perusahaan */
    doc.setFontSize(17); doc.setFont('helvetica','bold'); doc.setTextColor(234,179,8);
    doc.text('MR. BROKKER_AP', pw/2, 18, {align:'center'});

    /* Sub-title */
    doc.setFontSize(10); doc.setFont('helvetica','normal'); doc.setTextColor(200,200,200);
    doc.text('MENS HAIRCUT & SHAVES', pw/2, 25, {align:'center'});

    /* Judul laporan */
    doc.setFontSize(13); doc.setFont('helvetica','bold'); doc.setTextColor(255,255,255);
    doc.text('LAPORAN PENDAPATAN', pw/2, 35, {align:'center'});

    /* Periode */
    doc.setFontSize(9); doc.setFont('helvetica','normal'); doc.setTextColor(180,180,180);
    doc.text(periodeLabel, pw/2, 43, {align:'center'});

    /* Garis emas bawah header */
    doc.setDrawColor(234,179,8); doc.setLineWidth(1.2);
    doc.line(0, 52, pw, 52);

    /* ═══════════════════════════════════════════════
       RINGKASAN — 3 kotak stat
    ═══════════════════════════════════════════════ */
    const boxW = (cw - 8) / 3;
    const statData = [
        { label:'Total Pendapatan',    value: formatRp(laporanData.totalPendapatan) },
        { label:'Total Reservasi',     value: laporanData.totalReservasi + ' Reservasi' },
        { label:'Rata-rata / Transaksi', value: formatRp(laporanData.totalReservasi > 0 ? Math.round(laporanData.totalPendapatan/laporanData.totalReservasi) : 0) },
    ];

    let bY = 58;
    statData.forEach((s, i) => {
        const bx = mg + i * (boxW + 4);
        /* Kotak latar */
        doc.setFillColor(26,26,26);
        doc.setDrawColor(60,60,60); doc.setLineWidth(0.3);
        doc.roundedRect(bx, bY, boxW, 18, 2, 2, 'FD');
        /* Garis emas atas kotak */
        doc.setFillColor(234,179,8);
        doc.rect(bx, bY, boxW, 1.8, 'F');
        /* Label */
        doc.setFontSize(6.5); doc.setFont('helvetica','normal'); doc.setTextColor(160,160,160);
        doc.text(s.label, bx + boxW/2, bY + 7, {align:'center'});
        /* Value */
        doc.setFontSize(9); doc.setFont('helvetica','bold'); doc.setTextColor(234,179,8);
        doc.text(s.value, bx + boxW/2, bY + 14, {align:'center'});
    });

    /* ═══════════════════════════════════════════════
       TABEL
    ═══════════════════════════════════════════════ */
    const harian = laporanData.grafikHarian;
    const tableRows = [];

    if (isRange) {
        const dariDate = new Date(laporanData.dari);
        const sampaiDate = new Date(laporanData.sampai); sampaiDate.setHours(23,59,59);
        for (let cur = new Date(dariDate); cur <= sampaiDate; cur.setDate(cur.getDate()+1)) {
            const label = cur.getDate()+' '+BULAN[cur.getMonth()]+' '+cur.getFullYear();
            const cocok = harian.find(d=>{ const dt=new Date(d.tanggal); return dt.getFullYear()===cur.getFullYear()&&dt.getMonth()===cur.getMonth()&&dt.getDate()===cur.getDate(); });
            tableRows.push([label, cocok ? String(cocok.jumlah??'') : '', cocok ? formatRp(cocok.total) : '-']);
        }
    } else {
        const jumlahHari = new Date(laporanData.tahun, laporanData.bulan, 0).getDate();
        for (let h=1; h<=jumlahHari; h++) {
            const label = h+' '+BULAN[laporanData.bulan-1]+' '+laporanData.tahun;
            const cocok = harian.find(d=>{ const dt=new Date(d.tanggal); return dt.getDate()===h&&dt.getMonth()+1===laporanData.bulan; });
            tableRows.push([label, cocok ? String(cocok.jumlah??'') : '', cocok ? formatRp(cocok.total) : '-']);
        }
    }

    /* Baris TOTAL */
    tableRows.push([
        { content:'', styles:{ fillColor:[234,179,8], textColor:[0,0,0] } },
        { content:'TOTAL PENDAPATAN', styles:{ fontStyle:'bold', halign:'right', fillColor:[234,179,8], textColor:[0,0,0] } },
        { content:formatRp(laporanData.totalPendapatan), styles:{ fontStyle:'bold', halign:'right', fillColor:[234,179,8], textColor:[0,0,0] } },
    ]);

    doc.autoTable({
        startY: bY + 24,
        head: [[
            { content:'TANGGAL',           styles:{ halign:'left'   } },
            { content:'JUMLAH TRANSAKSI',  styles:{ halign:'center' } },
            { content:'JUMLAH PENDAPATAN', styles:{ halign:'right'  } },
        ]],
        body: tableRows,
        margin: { left:mg, right:mg },
        tableWidth: cw,
        styles: {
            fontSize: 8.5,
            cellPadding: { top:3, bottom:3, left:5, right:5 },
            lineColor: [220,220,220],
            lineWidth: 0.25,
            textColor: [30,30,30],
            font: 'helvetica',
            fillColor: [255,255,255],
        },
        headStyles: {
            fillColor: [15,15,15],
            textColor: [234,179,8],
            fontStyle: 'bold',
            fontSize: 8.5,
            lineWidth: 0,
        },
        bodyStyles: {
            fillColor: [255,255,255],
            textColor: [30,30,30],
        },
        alternateRowStyles: {
            fillColor: [250,250,250],
        },
        columnStyles: {
            0: { cellWidth:65 },
            1: { cellWidth:52, halign:'center' },
            2: { halign:'right' },
        },
        didParseCell: function(data) {
            if (data.row.index === tableRows.length - 1 && data.section === 'body') {
                data.cell.styles.fontStyle = 'bold';
            }
        }
    });

    /* ═══════════════════════════════════════════════
       FOOTER
    ═══════════════════════════════════════════════ */
    const endY = doc.lastAutoTable.finalY + 5;

    /* Garis footer */
    doc.setDrawColor(234,179,8); doc.setLineWidth(0.5);
    doc.line(mg, endY, pw-mg, endY);

    doc.setFontSize(7); doc.setFont('helvetica','italic'); doc.setTextColor(130,130,130);
    doc.text('Mr. Brokker_AP — Mens Haircut & Shaves', mg, endY + 5);
    doc.text(
        'Dicetak: ' + new Date().toLocaleDateString('id-ID',{day:'2-digit',month:'long',year:'numeric'}),
        pw - mg, endY + 5, { align:'right' }
    );

    /* Nomor halaman */
    const totalPages = doc.internal.getNumberOfPages();
    for (let i = 1; i <= totalPages; i++) {
        doc.setPage(i);
        doc.setFontSize(7); doc.setFont('helvetica','normal'); doc.setTextColor(160,160,160);
        doc.text('Hal. '+i+' / '+totalPages, pw/2, ph-6, {align:'center'});
    }

    const fileName = isRange
        ? 'Laporan_'+laporanData.dari+'_sd_'+laporanData.sampai+'.pdf'
        : 'Laporan_'+BULAN[laporanData.bulan-1]+'_'+laporanData.tahun+'.pdf';
    doc.save(fileName);
}
</script>

</body>
</html>