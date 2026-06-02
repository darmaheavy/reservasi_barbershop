<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Status — Mr. Brokker</title>
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
        .stat-card:hover { border-color: #EAB308; transform: translateY(-2px); }
    </style>
</head>
<body style="background:#0e0e0e; color:white;">

<div class="flex min-h-screen">

    <!-- SIDEBAR -->
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

    <!-- MAIN CONTENT -->
    <main class="flex-1 overflow-auto">

        <!-- Header -->
        <div class="px-8 py-6 border-b border-gray-800 flex items-center justify-between" style="background:#111;">
            <div>
                <h1 class="text-xl font-bold font-display text-white">Manajemen Status</h1>
                <p class="text-gray-500 text-sm mt-0.5">Kelola status setiap reservasi pelanggan</p>
            </div>
            <div class="text-gray-500 text-sm">{{ now()->format('l, d F Y') }}</div>
        </div>

        <div class="px-8 py-8">

            <!-- Mini Stat Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-5 mb-8">
                <div class="stat-card p-6">
                    <div class="flex items-center justify-between mb-4">
                        <p class="text-gray-400 text-sm">Menunggu</p>
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background:rgba(234,179,8,0.15);">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#EAB308" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                        </div>
                    </div>
                    <p class="text-3xl font-bold text-white font-display">{{ $reservations->where('status','pending')->count() }}</p>
                    <p class="text-gray-500 text-xs mt-1">Perlu ditindaklanjuti</p>
                </div>
                <div class="stat-card p-6">
                    <div class="flex items-center justify-between mb-4">
                        <p class="text-gray-400 text-sm">Dikonfirmasi</p>
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background:rgba(34,197,94,0.15);">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#22c55e" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22,4 12,14.01 9,11.01"/></svg>
                        </div>
                    </div>
                    <p class="text-3xl font-bold text-white font-display">{{ $reservations->where('status','confirmed')->count() }}</p>
                    <p class="text-gray-500 text-xs mt-1">Berhasil dikonfirmasi</p>
                </div>
                <div class="stat-card p-6">
                    <div class="flex items-center justify-between mb-4">
                        <p class="text-gray-400 text-sm">Dibatalkan</p>
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background:rgba(239,68,68,0.15);">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#ef4444" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                        </div>
                    </div>
                    <p class="text-3xl font-bold text-white font-display">{{ $reservations->where('status','cancelled')->count() }}</p>
                    <p class="text-gray-500 text-xs mt-1">Reservasi dibatalkan</p>
                </div>
            </div>

            <!-- Table -->
            <div class="stat-card p-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-lg font-bold font-display">Daftar Reservasi</h2>
                    <span class="text-gray-500 text-sm">{{ $reservations->count() }} total</span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-gray-800">
                                <th class="text-left text-gray-500 font-medium pb-3">Nama</th>
                                <th class="text-left text-gray-500 font-medium pb-3">Layanan</th>
                                <th class="text-left text-gray-500 font-medium pb-3">Tanggal</th>
                                <th class="text-left text-gray-500 font-medium pb-3">Status</th>
                                <th class="text-left text-gray-500 font-medium pb-3">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-800">
                            @foreach($reservations as $r)
                            <tr>
                                {{-- PERBAIKAN: $r->name -> $r->nama --}}
                                <td class="py-3 text-white font-medium">{{ $r->nama }}</td>
                                {{-- PERBAIKAN: $r->service -> $r->layanan --}}
                                <td class="py-3 text-gray-400">{{ $r->layanan }}</td>
                                {{-- PERBAIKAN: $r->date -> $r->tanggal --}}
                                <td class="py-3 text-gray-400">{{ \Carbon\Carbon::parse($r->tanggal)->format('d M Y') }}</td>
                                <td class="py-3">
                                    @if($r->status === 'confirmed')
                                        <span class="px-2 py-1 rounded-full text-xs font-semibold" style="background:rgba(34,197,94,0.15);color:#22c55e;">Dikonfirmasi</span>
                                    @elseif($r->status === 'cancelled')
                                        <span class="px-2 py-1 rounded-full text-xs font-semibold" style="background:rgba(239,68,68,0.15);color:#ef4444;">Dibatalkan</span>
                                    @else
                                        <span class="px-2 py-1 rounded-full text-xs font-semibold" style="background:rgba(234,179,8,0.15);color:#EAB308;">Menunggu</span>
                                    @endif
                                </td>
                                <td class="py-3">
                                    <form action="{{ route('admin.reservations.status', $r->id) }}" method="POST" class="flex gap-2 items-center">
                                        @csrf
                                        @method('PUT')
                                        <select name="status" class="bg-[#111] border border-gray-700 rounded px-2 py-1 text-sm text-white">
                                            <option value="pending" {{ $r->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="confirmed" {{ $r->status === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                            <option value="cancelled" {{ $r->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                        </select>
                                        <button class="bg-[#EAB308] text-black px-3 py-1 rounded text-xs font-bold hover:opacity-90 transition">
                                            Update
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    @if($reservations->isEmpty())
                        <div class="text-center py-12 text-gray-500">
                            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="mx-auto mb-3 opacity-40"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                            <p>Belum ada data reservasi</p>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </main>
</div>

</body>
</html>