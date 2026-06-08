<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Operasional — Mr. Brokker</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'DM Sans', sans-serif; }
        .font-display { font-family: 'Playfair Display', serif; }
        .sidebar-link { transition: all 0.2s; }
        .sidebar-link:hover, .sidebar-link.active {
            background: rgba(234,179,8,0.15);
            color: #EAB308;
            border-left: 3px solid #EAB308;
        }
        .sidebar-link:not(.active):not(:hover) { border-left: 3px solid transparent; }
        .stat-card { background: #1a1a1a; border: 1px solid #2a2a2a; border-radius: 16px; transition: all 0.3s; }
        .stat-card:hover { border-color: #EAB308; }

        .jadwal-row { transition: all 0.3s; }
        .jadwal-row:hover { background: rgba(234,179,8,0.04); }

        /* Toggle Switch */
        .toggle-checkbox { display: none; }
        .toggle-label {
            display: flex; align-items: center; cursor: pointer;
            width: 52px; height: 28px; background: #333;
            border-radius: 999px; position: relative; transition: background 0.3s;
        }
        .toggle-label::after {
            content: ''; position: absolute; left: 4px;
            width: 20px; height: 20px; background: white;
            border-radius: 50%; transition: transform 0.3s;
        }
        .toggle-checkbox:checked + .toggle-label { background: #EAB308; }
        .toggle-checkbox:checked + .toggle-label::after { transform: translateX(24px); }

        input[type="time"]::-webkit-calendar-picker-indicator { filter: invert(1) brightness(0.6); cursor: pointer; }

        .badge-buka { background: rgba(34,197,94,0.15); color: #22c55e; }
        .badge-tutup { background: rgba(239,68,68,0.12); color: #ef4444; }

        .save-btn {
            background: #EAB308; color: black; font-weight: 700;
            border-radius: 10px; padding: 7px 20px; font-size: 13px;
            transition: all 0.2s; border: none; cursor: pointer;
        }
        .save-btn:hover { background: #ca8a04; transform: scale(1.03); }
        .save-btn:disabled { background: #555; color: #999; cursor: not-allowed; transform: none; }

        .input-time {
            background: #111; border: 1px solid #333; color: white;
            border-radius: 8px; padding: 6px 10px; font-size: 13px;
            transition: border 0.2s; outline: none; width: 108px;
        }
        .input-time:focus { border-color: #EAB308; }
        .input-time:disabled { opacity: 0.35; cursor: not-allowed; }
    </style>
</head>
<body style="background:#0e0e0e; color:white;">

<div class="flex min-h-screen">

    {{-- ─── SIDEBAR ─────────────────────────────────────── --}}
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
               class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-400">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/></svg>
                Dashboard
            </a>
            <a href="{{ route('admin.reservations') }}"
               class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-400">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
                Reservasi
            </a>
            <a href="{{ route('admin.antrian') }}"
               class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-400">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                Antrian
            </a>

            <p class="text-gray-600 text-xs font-semibold uppercase tracking-wider px-3 mt-4 mb-2">Manajemen</p>

            <a href="{{ route('admin.layanan') }}"
               class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-400">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/></svg>
                Layanan
            </a>
            
             {{-- Jadwal — active --}}
            <a href="{{ route('admin.jadwal') }}"
               class="sidebar-link {{ request()->routeIs('admin.jadwal') ? 'active' : '' }} flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('admin.jadwal') ? 'text-[#EAB308]' : 'text-gray-400' }}">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18M12 14v4M16 16H8"/></svg>
               Jadwal Buka
            </a>

            <a href="{{ route('admin.laporan') }}"
               class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-400">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>
                Laporan
            </a>
            <a href="{{ route('admin.status') }}"
               class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-400">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                Status
            </a>
            <a href="{{ route('admin.galeri') }}"
               class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-400">
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

    {{-- ─── MAIN CONTENT ────────────────────────────────── --}}
    <main class="flex-1 overflow-auto">

        {{-- Header --}}
        <div class="px-8 py-6 border-b border-gray-800 flex items-center justify-between" style="background:#111;">
            <div>
                <h1 class="text-xl font-bold font-display text-white">Jadwal Operasional</h1>
                <p class="text-gray-500 text-sm mt-0.5">Atur jam buka, jam tutup, dan hari libur barbershop</p>
            </div>
            <div class="text-gray-500 text-sm">{{ now()->format('l, d F Y') }}</div>
        </div>

        <div class="px-8 py-8 max-w-4xl">

            {{-- Alert --}}
            @if(session('success'))
                <div class="mb-6 flex items-center gap-3 px-5 py-4 rounded-xl border border-green-500/30 bg-green-500/10 text-green-300 text-sm">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22,4 12,14.01 9,11.01"/></svg>
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="mb-6 flex items-center gap-3 px-5 py-4 rounded-xl border border-red-500/30 bg-red-500/10 text-red-300 text-sm">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    {{ session('error') }}
                </div>
            @endif

         {{-- ───────────────── INFO BANNER ───────────────── --}}
<div class="mb-6 flex items-start gap-3 px-5 py-4 rounded-xl border border-yellow-500/20 bg-yellow-500/5">
    <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
         stroke="#EAB308" stroke-width="2"
         class="shrink-0 mt-0.5">
        <circle cx="12" cy="12" r="10"/>
        <line x1="12" y1="8" x2="12" y2="12"/>
        <line x1="12" y1="16" x2="12.01" y2="16"/>
    </svg>

    <p class="text-yellow-200/70 text-xs leading-relaxed">
        Admin dapat mengubah jadwal operasional dan status buka/tutup barbershop secara langsung.
    </p>
</div>



{{-- ───────────────── JADWAL CARD ───────────────── --}}
<div class="stat-card overflow-hidden">

    {{-- Card Header --}}
    <div class="px-6 py-5 border-b border-gray-800 flex items-center gap-3">

        <div class="w-9 h-9 rounded-xl flex items-center justify-center shrink-0"
             style="background:rgba(234,179,8,0.15);">

            <svg width="16"
                 height="16"
                 viewBox="0 0 24 24"
                 fill="none"
                 stroke="#EAB308"
                 stroke-width="2">

                <rect x="3" y="4" width="18" height="18" rx="2"/>
                <path d="M16 2v4M8 2v4M3 10h18"/>

            </svg>

        </div>

        <div>
            <p class="text-white font-semibold text-sm">
                Jadwal Operasional
            </p>

            <p class="text-gray-500 text-xs">
                Edit jadwal operasional barbershop
            </p>
        </div>

    </div>

    {{-- Table Header --}}
    <div class="grid px-6 py-3 border-b border-gray-800/60
                text-xs font-semibold uppercase tracking-wider text-gray-500"
         style="grid-template-columns: 130px 90px 90px 110px 100px 120px;">

        <span>Hari</span>
        <span>Status</span>
        <span>Jam Buka</span>
        <span>Jam Tutup</span>
        <span>Slot</span>
        <span>Aksi</span>

    </div>

    {{-- Rows --}}
    @foreach($jadwal as $j)

    <div class="jadwal-row border-b border-gray-800/40 last:border-0">

        <form class="jadwal-form" action="{{ route('admin.jadwal.update', $j->id) }}" data-id="{{ $j->id }}"
              method="POST" data-id="{{ $j->id }}">

            @csrf
            @method('PUT')

            <div class="grid items-center px-6 py-4 gap-4"
                 style="grid-template-columns: 130px 90px 90px 110px 100px 120px;">

                {{-- Nama Hari --}}
                <div class="flex items-center gap-3">

                    <span class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold shrink-0
                        {{ $j->is_buka ? 'bg-[#EAB308]/15 text-[#EAB308]' : 'bg-gray-800 text-gray-500' }}">

                        {{ strtoupper(substr($j->nama_hari, 0, 2)) }}

                    </span>

                    <span class="text-sm font-semibold
                        {{ $j->is_buka ? 'text-white' : 'text-gray-500' }}">

                        {{ $j->nama_hari }}

                    </span>

                </div>

                {{-- Status --}}
                <div>

                    <select name="is_buka"
                            class="input-time w-full">

                        <option value="1"
                            {{ $j->is_buka ? 'selected' : '' }}>
                            Buka
                        </option>

                        <option value="0"
                            {{ !$j->is_buka ? 'selected' : '' }}>
                            Tutup
                        </option>

                    </select>

                </div>

                {{-- Jam Buka --}}
                <div>

                    <input type="time"
                           name="jam_buka"
                           value="{{ \Carbon\Carbon::parse($j->jam_buka)->format('H:i') }}"
                           class="input-time w-full">

                </div>

                {{-- Jam Tutup --}}
                <div>

                    <input type="time"
                           name="jam_tutup"
                           value="{{ \Carbon\Carbon::parse($j->jam_tutup)->format('H:i') }}"
                           class="input-time w-full">

                </div>

                {{-- Slot --}}
                <div>

                    @php
                        $buka = \Carbon\Carbon::parse($j->jam_buka);
                        $tutup = \Carbon\Carbon::parse($j->jam_tutup);

                        $slots = floor(
                            $buka->diffInMinutes($tutup) / 45
                        );
                    @endphp

                    @if($j->is_buka)

                        <span class="text-[#EAB308] text-sm font-semibold">
                            {{ $slots }}
                        </span>

                        <span class="text-gray-500 text-xs">
                            slot
                        </span>

                    @else

                        <span class="text-gray-600 text-xs">
                            —
                        </span>

                    @endif

                </div>

                {{-- Tombol --}}
                <div class="flex items-center gap-3">

                    @if($j->is_buka)

                        <span class="badge-buka px-2.5 py-1 rounded-full text-xs font-semibold">
                            Buka
                        </span>

                    @else

                        <span class="badge-tutup px-2.5 py-1 rounded-full text-xs font-semibold">
                            Tutup
                        </span>

                    @endif

                    <button type="submit"
                            class="save-btn">

                        Simpan

                    </button>

                </div>

            </div>

        </form>

    </div>

    @endforeach

</div>