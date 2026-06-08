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
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'DM Sans', sans-serif; }
        .font-display { font-family: 'Playfair Display', serif; }
        .sidebar-link { transition: all 0.2s; }
        .sidebar-link:hover, .sidebar-link.active { background: rgba(234,179,8,0.15); color: #EAB308; border-left: 3px solid #EAB308; }
        .card { background: #1a1a1a; border: 1px solid #2a2a2a; border-radius: 16px; }
        .stat-card { background: #1a1a1a; border: 1px solid #2a2a2a; border-radius: 16px; transition: all 0.3s; }
        .stat-card:hover { border-color: #EAB308; transform: translateY(-2px); }
        .select-filter { background: #222; border: 1px solid #333; border-radius: 8px; color: white; padding: 0.5rem 0.9rem; font-size: 0.875rem; outline: none; cursor: pointer; }
        .select-filter:focus { border-color: #EAB308; }
        .btn-export { background: #EAB308; color: #000; border: none; border-radius: 8px; padding: 0.5rem 1.1rem; font-size: 0.875rem; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 0.4rem; transition: all 0.2s; }
        .btn-export:hover { background: #ca9e06; }
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
                <h1 class="text-xl font-bold font-display text-white">Laporan Pendapatan</h1>
                <p class="text-gray-500 text-sm mt-0.5">Rekap pendapatan berdasarkan reservasi yang dikonfirmasi</p>
            </div>
            <div class="flex items-center gap-3">
                <form method="GET" action="{{ route('admin.laporan') }}" class="flex items-center gap-3">
                    <select name="bulan" class="select-filter" onchange="this.form.submit()">
                        @for($m = 1; $m <= 12; $m++)
                            <option value="{{ $m }}" {{ $bulan == $m ? 'selected' : '' }}>
                                {{ \Carbon\Carbon::create()->month($m)->locale('id')->monthName }}
                            </option>
                        @endfor
                    </select>
                    <select name="tahun" class="select-filter" onchange="this.form.submit()">
                        @for($y = \Carbon\Carbon::now()->year; $y >= \Carbon\Carbon::now()->year - 2; $y--)
                            <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endfor
                    </select>
                </form>
                <button class="btn-export" onclick="exportPDF()">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7,10 12,15 17,10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                    Export PDF
                </button>
            </div>
        </div>

        <div class="px-8 py-8">

            <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-8">
                <div class="stat-card p-6">
                    <div class="flex items-center justify-between mb-3">
                        <p class="text-gray-400 text-sm">Total Pendapatan Bulan Ini</p>
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background:rgba(234,179,8,0.15);">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#EAB308" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                        </div>
                    </div>
                    <p class="text-3xl font-bold text-[#EAB308] font-display">Rp{{ number_format($totalPendapatan, 0, ',', '.') }}</p>
                    <p class="text-gray-500 text-xs mt-1">{{ \Carbon\Carbon::create()->month((int)$bulan)->locale('id')->monthName }} {{ $tahun }}</p>
                </div>
                <div class="stat-card p-6">
                    <div class="flex items-center justify-between mb-3">
                        <p class="text-gray-400 text-sm">Total Reservasi Selesai</p>
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background:rgba(34,197,94,0.15);">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#22c55e" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22,4 12,14.01 9,11.01"/></svg>
                        </div>
                    </div>
                    <p class="text-3xl font-bold text-white font-display">{{ $totalReservasi }}</p>
                    <p class="text-gray-500 text-xs mt-1">Reservasi dikonfirmasi</p>
                </div>
                <div class="stat-card p-6">
                    <div class="flex items-center justify-between mb-3">
                        <p class="text-gray-400 text-sm">Rata-rata per Reservasi</p>
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background:rgba(139,92,246,0.15);">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#8b5cf6" stroke-width="2"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>
                        </div>
                    </div>
                    <p class="text-3xl font-bold text-white font-display">Rp{{ $totalReservasi > 0 ? number_format($totalPendapatan / $totalReservasi, 0, ',', '.') : '0' }}</p>
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
                            <div class="flex items-center gap-3 flex-1">
                                <div class="text-sm text-white font-medium">{{ $l->service }}</div>
                            </div>
                            <div class="text-right">
                                <p class="text-[#EAB308] font-semibold text-sm">Rp{{ number_format($l->total, 0, ',', '.') }}</p>
                                <p class="text-gray-500 text-xs">{{ $l->jumlah }}x transaksi</p>
                            </div>
                        </div>
                        <div class="w-full rounded-full h-1.5" style="background:#2a2a2a;">
                            <div class="h-1.5 rounded-full" style="background:#EAB308; width:{{ $totalPendapatan > 0 ? ($l->total / $totalPendapatan * 100) : 0 }}%"></div>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>

                <div class="card p-6">
                    <h2 class="text-base font-bold font-display mb-4">Transaksi Terbaru</h2>
                    @if(!isset($detailTransaksi) || $detailTransaksi->isEmpty())
                        <p class="text-gray-500 text-sm text-center py-8">Belum ada transaksi</p>
                    @else
                    <div class="space-y-3">
                        @foreach($detailTransaksi as $t)
                        <div class="flex items-center justify-between py-2 border-b border-gray-800 last:border-0">
                            <div>
                                <p class="text-white text-sm font-medium">{{ $t->name }}</p>
                                <p class="text-gray-500 text-xs">{{ $t->service }} · {{ \Carbon\Carbon::parse($t->date)->format('d M') }}</p>
                            </div>
                            <p class="text-[#EAB308] font-semibold text-sm">Rp{{ number_format($t->harga ?? 0, 0, ',', '.') }}</p>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>

        </div>
    </main>
</div>

{{-- Data untuk dikirim ke JavaScript --}}
<script>
    // Data dari Laravel (digunakan untuk PDF export)
    const laporanData = {
        namaBulan: "{{ \Carbon\Carbon::create()->month((int)$bulan)->locale('id')->translatedFormat('F') }}",
        tahun: "{{ $tahun }}",
        totalPendapatan: {{ $totalPendapatan }},
        totalReservasi: {{ $totalReservasi }},
        rataRata: {{ $totalReservasi > 0 ? intval($totalPendapatan / $totalReservasi) : 0 }},
        grafikHarian: @json($grafikHarian ?? []),
        perLayanan: @json($perLayanan ?? []),
        detailTransaksi: @json($detailTransaksi ?? []),
    };
</script>

@if(isset($grafikHarian) && count($grafikHarian) > 0)
<script>
const ctx = document.getElementById('grafikPendapatan').getContext('2d');
const grafikData = @json($grafikHarian);

new Chart(ctx, {
    type: 'bar',
    data: {
        labels: grafikData.map(d => d.tanggal),
        datasets: [{
            label: 'Pendapatan (Rp)',
            data: grafikData.map(d => d.total),
            backgroundColor: 'rgba(234,179,8,0.3)',
            borderColor: '#EAB308',
            borderWidth: 2,
            borderRadius: 6,
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { display: false },
            tooltip: {
                callbacks: {
                    label: (ctx) => 'Rp ' + ctx.raw.toLocaleString('id-ID')
                }
            }
        },
        scales: {
            x: {
                grid: { color: 'rgba(255,255,255,0.05)' },
                ticks: { color: '#6b7280', font: { size: 11 } }
            },
            y: {
                grid: { color: 'rgba(255,255,255,0.05)' },
                ticks: {
                    color: '#6b7280',
                    font: { size: 11 },
                    callback: (val) => 'Rp ' + val.toLocaleString('id-ID')
                }
            }
        }
    }
});
</script>
@endif

<script>
function formatRupiah(angka) {
    return 'Rp' + Number(angka).toLocaleString('id-ID');
}

function exportPDF() {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF({ orientation: 'portrait', unit: 'mm', format: 'a4' });

    const pageW = doc.internal.pageSize.getWidth();
    const margin = 15;
    const contentW = pageW - margin * 2;

    // ─── HEADER ───────────────────────────────────────────────

    // Nama perusahaan & judul
    doc.setFontSize(13);
    doc.setFont('helvetica', 'bold');
    doc.setTextColor(0);
    doc.text('Mr. Brokerr', pageW / 2, 17, { align: 'center' });

    doc.setFontSize(11);
    doc.text('LAPORAN PENDAPATAN', pageW / 2, 23, { align: 'center' });

    doc.setFontSize(10);
    doc.setFont('helvetica', 'normal');
    doc.text(
        'Bulan ' + laporanData.namaBulan.toUpperCase() + ' Tahun ' + laporanData.tahun,
        pageW / 2, 29, { align: 'center' }
    );

    let cursorY = 38;

    // ─── TABEL HARIAN ─────────────────────────────────────────
    const harian = laporanData.grafikHarian;
    const jumlahHari = new Date(laporanData.tahun, new Date(Date.parse(laporanData.namaBulan + ' 1, ' + laporanData.tahun)).getMonth() + 1, 0).getDate();

    // Buat peta data harian dari grafikHarian
    const harianMap = {};
    harian.forEach(d => { harianMap[d.tanggal] = d; });

    // Buat rows per tanggal (1 sampai akhir bulan)
    const bulanIndex = new Date(Date.parse(laporanData.namaBulan + ' 1, ' + laporanData.tahun)).getMonth() + 1;
    const tableRows = [];

    for (let hari = 1; hari <= jumlahHari; hari++) {
        const tgl = String(hari) + ' ' + laporanData.namaBulan + ' ' + laporanData.tahun;
        // Cari data yang cocok
        const cocok = harian.find(d => {
            const parsed = new Date(d.tanggal);
            return parsed.getDate() === hari;
        });
        const jumlahTrx = cocok ? (cocok.jumlah ?? '') : '';
        const pendapatan = cocok ? formatRupiah(cocok.total) : '';
        tableRows.push([hari + ' ' + laporanData.namaBulan + ' ' + laporanData.tahun, jumlahTrx, pendapatan]);
    }

    // Baris total di bawah
    tableRows.push([
        { content: '', styles: { fillColor: [255,255,255] } },
        { content: 'TOTAL PENDAPATAN', colSpan: 1, styles: { fontStyle: 'bold', halign: 'right', fillColor: [245,245,245] } },
        { content: formatRupiah(laporanData.totalPendapatan), styles: { fontStyle: 'bold', fillColor: [245,245,245] } }
    ]);

    doc.autoTable({
        startY: cursorY,
        head: [[
            { content: 'TANGGAL', styles: { halign: 'left' } },
            { content: 'JUMLAH TRANSAKSI', styles: { halign: 'center' } },
            { content: 'JUMLAH PENDAPATAN', styles: { halign: 'right' } }
        ]],
        body: tableRows,
        margin: { left: margin, right: margin },
        tableWidth: contentW,
        styles: {
            fontSize: 9,
            cellPadding: { top: 3, bottom: 3, left: 4, right: 4 },
            lineColor: [0, 0, 0],
            lineWidth: 0.3,
            textColor: [0, 0, 0],
            font: 'helvetica',
        },
        headStyles: {
            fillColor: [255, 255, 255],
            textColor: [0, 0, 0],
            fontStyle: 'bold',
            fontSize: 9,
            lineWidth: 0.3,
            lineColor: [0, 0, 0],
        },
        bodyStyles: {
            fillColor: [255, 255, 255],
        },
        alternateRowStyles: {
            fillColor: [255, 255, 255],
        },
        columnStyles: {
            0: { cellWidth: 55 },
            1: { cellWidth: 55, halign: 'center' },
            2: { halign: 'right' },
        },
        didParseCell: function(data) {
            // Baris terakhir (total)
            if (data.row.index === tableRows.length - 1) {
                data.cell.styles.fontStyle = 'bold';
            }
        }
    });

    const fileName = 'Laporan_Pendapatan_' + laporanData.namaBulan + '_' + laporanData.tahun + '.pdf';
    doc.save(fileName);
}
</script>

</body>
</html>