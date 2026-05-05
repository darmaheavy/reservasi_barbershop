<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Layanan — Mr. Brokker</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <style>
        * { font-family: 'DM Sans', sans-serif; }
        .font-display { font-family: 'Playfair Display', serif; }
        .sidebar-link { transition: all 0.2s; }
        .sidebar-link:hover, .sidebar-link.active { background: rgba(234,179,8,0.15); color: #EAB308; border-left: 3px solid #EAB308; }
        .card { background: #1a1a1a; border: 1px solid #2a2a2a; border-radius: 16px; }
        .input { background: #222; border: 1px solid #333; border-radius: 8px; color: white; padding: 0.6rem 0.9rem; width: 100%; font-size: 0.875rem; outline: none; transition: border 0.2s; }
        .input:focus { border-color: #EAB308; }
        .input::placeholder { color: #555; }
        .btn-gold { background: #EAB308; color: black; font-weight: 700; padding: 0.6rem 1.2rem; border-radius: 8px; font-size: 0.875rem; transition: all 0.2s; }
        .btn-gold:hover { background: #ca9f00; }
        .modal { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.7); z-index: 50; align-items: center; justify-content: center; }
        .modal.open { display: flex; }
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
        <nav class="flex-1 px-3 py-4 space-y-1">
            <p class="text-gray-600 text-xs font-semibold uppercase tracking-wider px-3 mb-2">Menu Utama</p>
            <a href="{{ route('admin.dashboard') }}" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-400">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/></svg>
                Dashboard
            </a>
            <a href="{{ route('admin.reservations') }}" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-400">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
                Reservasi
            </a>
            <a href="{{ route('admin.layanan') }}" class="sidebar-link active flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                Layanan
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

    <!-- MAIN -->
    <main class="flex-1 overflow-auto">
        <div class="px-8 py-6 border-b border-gray-800 flex items-center justify-between" style="background:#111;">
            <div>
                <h1 class="text-xl font-bold font-display text-white">Kelola Layanan</h1>
                <p class="text-gray-500 text-sm mt-0.5">Tambah, edit, dan hapus layanan barbershop</p>
            </div>
            <button onclick="document.getElementById('modalTambah').classList.add('open')" class="btn-gold flex items-center gap-2">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Tambah Layanan
            </button>
        </div>

        <div class="px-8 py-8">

            @if(session('success'))
            <div class="mb-6 px-4 py-3 rounded-xl text-sm font-medium flex items-center gap-2" style="background:rgba(34,197,94,0.1);border:1px solid rgba(34,197,94,0.3);color:#22c55e;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22,4 12,14.01 9,11.01"/></svg>
                {{ session('success') }}
            </div>
            @endif

            <div class="card p-6">
                @if($layanan->isEmpty())
                    <div class="text-center py-16 text-gray-500">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="mx-auto mb-4 opacity-30"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                        <p class="text-lg font-medium">Belum ada layanan</p>
                        <p class="text-sm mt-1">Tambahkan layanan pertama kamu</p>
                    </div>
                @else
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-gray-800">
                                <th class="text-left text-gray-500 font-medium pb-4 pr-4">Icon</th>
                                <th class="text-left text-gray-500 font-medium pb-4 pr-4">Nama Layanan</th>
                                <th class="text-left text-gray-500 font-medium pb-4 pr-4">Harga</th>
                                <th class="text-left text-gray-500 font-medium pb-4 pr-4">Deskripsi</th>
                                <th class="text-left text-gray-500 font-medium pb-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-800">
                            @foreach($layanan as $l)
                            <tr>
                                <td class="py-4 pr-4">
                                    <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background:rgba(234,179,8,0.15);">
                                        <i class='bx {{ $l->icon }}' style="color:#EAB308; font-size:20px;"></i>
                                    </div>
                                </td>
                                <td class="py-4 pr-4 text-white font-medium">{{ $l->nama }}</td>
                                <td class="py-4 pr-4 text-[#EAB308] font-semibold">Rp{{ number_format($l->harga, 0, ',', '.') }}</td>
                                <td class="py-4 pr-4 text-gray-400 max-w-xs">{{ Str::limit($l->deskripsi, 60) }}</td>
                                <td class="py-4">
                                    <div class="flex items-center gap-2">
                                        <!-- Edit -->
                                        <button onclick="openEditModal({{ $l->id }}, '{{ addslashes($l->nama) }}', {{ $l->harga }}, '{{ addslashes($l->deskripsi) }}', '{{ $l->icon }}')"
                                            class="px-3 py-1.5 rounded-lg text-xs font-semibold transition hover:opacity-80"
                                            style="background:rgba(234,179,8,0.15);color:#EAB308;border:1px solid rgba(234,179,8,0.3);">
                                            ✏ Edit
                                        </button>
                                        <!-- Hapus -->
                                        <form action="{{ route('admin.layanan.delete', $l->id) }}" method="POST" onsubmit="return confirm('Yakin hapus layanan ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="px-3 py-1.5 rounded-lg text-xs font-semibold transition hover:opacity-80" style="background:rgba(239,68,68,0.15);color:#ef4444;border:1px solid rgba(239,68,68,0.3);">
                                                🗑 Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
            </div>
        </div>
    </main>
</div>

<!-- MODAL TAMBAH -->
<div id="modalTambah" class="modal">
    <div class="w-full max-w-md mx-4 rounded-2xl p-6" style="background:#1a1a1a; border:1px solid #2a2a2a;">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-lg font-bold font-display">Tambah Layanan</h2>
            <button onclick="document.getElementById('modalTambah').classList.remove('open')" class="text-gray-500 hover:text-white">✕</button>
        </div>
        <form action="{{ route('admin.layanan.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="text-gray-400 text-xs font-medium mb-1 block">Nama Layanan</label>
                <input type="text" name="nama" class="input" placeholder="contoh: Potong Rambut" required>
            </div>
            <div>
                <label class="text-gray-400 text-xs font-medium mb-1 block">Harga (Rp)</label>
                <input type="number" name="harga" class="input" placeholder="contoh: 30000" required>
            </div>
            <div>
                <label class="text-gray-400 text-xs font-medium mb-1 block">Deskripsi</label>
                <textarea name="deskripsi" class="input" rows="3" placeholder="Deskripsi layanan..." required></textarea>
            </div>
            <div>
                <label class="text-gray-400 text-xs font-medium mb-1 block">Icon (emoji)</label>
                <input type="text" name="icon" class="input" placeholder="contoh: ✂️ 💈 ⭐" required>
                <p class="text-gray-600 text-xs mt-1">Gunakan emoji sebagai icon</p>
            </div>
            <div class="flex gap-3 pt-2">
                <button type="button" onclick="document.getElementById('modalTambah').classList.remove('open')"
                    class="flex-1 py-2.5 rounded-lg text-sm font-medium text-gray-400 border border-gray-700 hover:border-gray-500 transition">
                    Batal
                </button>
                <button type="submit" class="flex-1 btn-gold py-2.5 rounded-lg text-sm">Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL EDIT -->
<div id="modalEdit" class="modal">
    <div class="w-full max-w-md mx-4 rounded-2xl p-6" style="background:#1a1a1a; border:1px solid #2a2a2a;">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-lg font-bold font-display">Edit Layanan</h2>
            <button onclick="document.getElementById('modalEdit').classList.remove('open')" class="text-gray-500 hover:text-white">✕</button>
        </div>
        <form id="formEdit" method="POST" class="space-y-4">
            @csrf @method('PUT')
            <div>
                <label class="text-gray-400 text-xs font-medium mb-1 block">Nama Layanan</label>
                <input type="text" name="nama" id="editNama" class="input" required>
            </div>
            <div>
                <label class="text-gray-400 text-xs font-medium mb-1 block">Harga (Rp)</label>
                <input type="number" name="harga" id="editHarga" class="input" required>
            </div>
            <div>
                <label class="text-gray-400 text-xs font-medium mb-1 block">Deskripsi</label>
                <textarea name="deskripsi" id="editDeskripsi" class="input" rows="3" required></textarea>
            </div>
            <div>
                <label class="text-gray-400 text-xs font-medium mb-1 block">Icon (emoji)</label>
                <input type="text" name="icon" id="editIcon" class="input" required>
            </div>
            <div class="flex gap-3 pt-2">
                <button type="button" onclick="document.getElementById('modalEdit').classList.remove('open')"
                    class="flex-1 py-2.5 rounded-lg text-sm font-medium text-gray-400 border border-gray-700 hover:border-gray-500 transition">
                    Batal
                </button>
                <button type="submit" class="flex-1 btn-gold py-2.5 rounded-lg text-sm">Update</button>
            </div>
        </form>
    </div>
</div>

<script>
function openEditModal(id, nama, harga, deskripsi, icon) {
    document.getElementById('editNama').value = nama;
    document.getElementById('editHarga').value = harga;
    document.getElementById('editDeskripsi').value = deskripsi;
    document.getElementById('editIcon').value = icon;
    document.getElementById('formEdit').action = `/admin/layanan/${id}`;
    document.getElementById('modalEdit').classList.add('open');
}

// Tutup modal kalau klik di luar
document.querySelectorAll('.modal').forEach(modal => {
    modal.addEventListener('click', function(e) {
        if (e.target === this) this.classList.remove('open');
    });
});
</script>

</body>
</html>