<x-app-layout>
    <div class="min-h-screen bg-[#0c0c0c] text-white font-sans py-12">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="bg-[#111] border-2 border-[#EAB308]/50 rounded-[40px] p-8 md:p-12 shadow-[0_0_50px_rgba(234,179,8,0.1)]">

                <div class="text-center mb-10">
                    <h2 class="text-[#EAB308] text-3xl font-bold uppercase tracking-widest">Booking Sekarang</h2>
                    <p class="text-gray-500 text-sm mt-2">Pilih tanggal terlebih dahulu untuk melihat slot yang tersedia</p>
                </div>

                @if(session('success'))
                    <div class="mb-6 p-4 bg-green-500/20 border border-green-500 text-green-300 rounded-xl">
                        {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="mb-6 p-4 bg-red-500/20 border border-red-500 text-red-300 rounded-xl">
                        <ul class="list-disc pl-5 text-sm">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('booking.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <!-- Nama -->
                    <div>
                        <label class="block text-sm font-bold text-gray-300 mb-2">Nama Lengkap</label>
                        <input type="text" name="nama"
                            value="{{ old('nama', Auth::user()->name) }}" required
                            class="w-full bg-[#1c1c1c] border border-gray-700 rounded-xl px-4 py-3 text-white focus:border-[#EAB308] focus:ring-1 focus:ring-[#EAB308] transition">
                    </div>

                    <!-- Layanan -->
                    <div>
                        <label class="block text-sm font-bold text-gray-300 mb-2">Layanan</label>
                        <select name="layanan" required
                            class="w-full bg-[#1c1c1c] border border-gray-700 rounded-xl px-4 py-3 text-white focus:border-[#EAB308] focus:ring-1 focus:ring-[#EAB308] transition appearance-none">
                            <option value="">-- Pilih Layanan --</option>
                            @foreach($layanan as $item)
                                <option value="{{ $item->nama }}" {{ old('layanan') == $item->nama ? 'selected' : '' }}>
                                    {{ $item->nama }} — Rp{{ number_format($item->harga, 0, ',', '.') }}
                                </option>
                            @endforeach
                        </select>
                        <p class="text-gray-500 text-[10px] mt-1">*Layanan diambil langsung dari daftar harga terbaru</p>
                    </div>

                    <!-- Tanggal -->
                    <div>
                        <label class="block text-sm font-bold text-gray-300 mb-2">Tanggal</label>
                        <input type="date" name="tanggal" id="tanggal"
                            value="{{ old('tanggal') }}" required
                            min="{{ date('Y-m-d') }}"
                            class="w-full bg-[#1c1c1c] border border-gray-700 rounded-xl px-4 py-3 text-white focus:border-[#EAB308] focus:ring-1 focus:ring-[#EAB308] transition color-scheme-dark">
                    </div>

                    <!-- Slot Jam -->
                    <div>
                        <label class="block text-sm font-bold text-gray-300 mb-2">
                            Pilih Jam
                            <span id="loadingSlot" class="hidden text-xs text-yellow-400 ml-2">⏳ Memuat slot...</span>
                        </label>

                        <!-- Placeholder sebelum tanggal dipilih -->
                        <div id="slotPlaceholder" class="w-full bg-[#1c1c1c] border border-dashed border-gray-700 rounded-xl px-4 py-4 text-gray-500 text-sm text-center">
                            📅 Pilih tanggal dulu untuk melihat slot yang tersedia
                        </div>

                        <!-- Grid slot jam -->
                        <div id="slotGrid" class="hidden">
                            <input type="hidden" name="jam" id="jamInput" value="{{ old('jam') }}">
                            <div id="slotContainer" class="grid grid-cols-3 sm:grid-cols-4 gap-3"></div>
                            <p id="slotError" class="hidden text-red-400 text-xs mt-2">⚠️ Pilih salah satu slot jam</p>
                        </div>

                        <!-- Semua penuh / libur -->
                        <div id="slotPenuh" class="hidden w-full bg-red-500/10 border border-red-500/30 rounded-xl px-4 py-4 text-red-400 text-sm text-center">
                            😔 Semua slot jam pada tanggal ini sudah penuh. Pilih tanggal lain.
                        </div>
                    </div>

                    <!-- WhatsApp -->
                    <div>
                        <label class="block text-sm font-bold text-gray-300 mb-2">Nomor WhatsApp</label>
                        <input type="text" name="whatsapp"
                            value="{{ old('whatsapp') }}" required
                            class="w-full bg-[#1c1c1c] border border-gray-700 rounded-xl px-4 py-3 text-white focus:border-[#EAB308] focus:ring-1 focus:ring-[#EAB308] transition"
                            placeholder="contoh: 08123456789">
                    </div>

                    <!-- Tombol -->
                    <div class="pt-6 space-y-3">
                        <button type="submit" id="btnSubmit"
                            class="w-full bg-[#EAB308] text-black font-black uppercase tracking-widest py-4 rounded-2xl hover:bg-yellow-500 hover:scale-[1.02] transition-all shadow-lg shadow-yellow-600/20">
                            Booking Sekarang
                        </button>
                        <a href="{{ route('booking.status') }}"
                            class="block text-center w-full border border-gray-600 py-3 rounded-xl hover:bg-gray-800 transition">
                            Lihat Status Booking
                        </a>
                    </div>

                </form>
            </div>

            <p class="text-center text-gray-500 text-xs mt-8 italic">
                *Pastikan data yang diisi sudah benar sebelum menekan tombol booking.
            </p>
        </div>
    </div>

    <style>
        .color-scheme-dark::-webkit-calendar-picker-indicator { filter: invert(1); }

        .slot-btn {
            padding: 10px 8px;
            border-radius: 12px;
            font-size: 13px;
            font-weight: 600;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s;
            border: 2px solid #333;
            background: #1c1c1c;
            color: #ccc;
        }
        .slot-btn:hover:not(.slot-penuh):not(.slot-lewat) {
            border-color: #EAB308;
            color: #EAB308;
            background: rgba(234,179,8,0.1);
        }
        .slot-btn.slot-selected {
            border-color: #EAB308;
            background: #EAB308;
            color: black;
        }
        .slot-btn.slot-penuh {
            border-color: #3f3f3f;
            background: #1a1a1a;
            color: #555;
            cursor: not-allowed;
            text-decoration: line-through;
        }
        .slot-btn.slot-lewat {
            border-color: #3f3f3f;
            background: #1a1a1a;
            color: #444;
            cursor: not-allowed;
        }
    </style>

    <script>
        const tanggalInput = document.getElementById('tanggal');
        const slotPlaceholder = document.getElementById('slotPlaceholder');
        const slotGrid = document.getElementById('slotGrid');
        const slotPenuh = document.getElementById('slotPenuh');
        const slotContainer = document.getElementById('slotContainer');
        const jamInput = document.getElementById('jamInput');
        const loadingSlot = document.getElementById('loadingSlot');
        const slotError = document.getElementById('slotError');

        tanggalInput.addEventListener('change', function () {
            const tanggal = this.value;
            if (!tanggal) return;

            // Reset state
            slotPlaceholder.classList.add('hidden');
            slotGrid.classList.add('hidden');
            slotPenuh.classList.add('hidden');
            loadingSlot.classList.remove('hidden');
            jamInput.value = '';
            slotContainer.innerHTML = '';

            fetch(`{{ route('booking.slots') }}?tanggal=${tanggal}`)
                .then(res => res.json())
                .then(data => {
                    loadingSlot.classList.add('hidden');

                    // Cek jika hari libur
                    if (data.libur) {
                        slotPenuh.classList.remove('hidden');
                        slotPenuh.innerHTML = `😔 ${data.pesan}`;
                        return;
                    }

                    const slots = data.slots;
                    const tersedia = slots.filter(s => s.tersedia);

                    if (tersedia.length === 0) {
                        slotPenuh.classList.remove('hidden');
                        slotPenuh.innerHTML = '😔 Semua slot jam pada tanggal ini sudah penuh. Pilih tanggal lain.';
                        return;
                    }

                    slotGrid.classList.remove('hidden');

                    slots.forEach(slot => {
                        const btn = document.createElement('button');
                        btn.type = 'button';
                        btn.textContent = slot.jam;
                        btn.classList.add('slot-btn');

                        if (!slot.tersedia) {
                            btn.classList.add(slot.label.includes('Penuh') ? 'slot-penuh' : 'slot-lewat');
                            btn.title = slot.label.includes('Penuh') ? 'Slot ini sudah dipesan' : 'Waktu sudah lewat';
                            btn.disabled = true;
                        } else {
                            if (jamInput.value === slot.jam) {
                                btn.classList.add('slot-selected');
                            }
                            btn.addEventListener('click', function () {
                                document.querySelectorAll('.slot-btn').forEach(b => b.classList.remove('slot-selected'));
                                this.classList.add('slot-selected');
                                jamInput.value = slot.jam;
                                slotError.classList.add('hidden');
                            });
                        }

                        slotContainer.appendChild(btn);
                    });
                })
                .catch(() => {
                    loadingSlot.classList.add('hidden');
                    slotPlaceholder.classList.remove('hidden');
                    slotPlaceholder.textContent = '❌ Gagal memuat slot. Coba lagi.';
                });
        }); // ← closing addEventListener

        // Validasi sebelum submit
        document.querySelector('form').addEventListener('submit', function (e) {
            if (!jamInput.value) {
                e.preventDefault();
                slotError.classList.remove('hidden');
                slotError.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        });

        // Auto load slot jika tanggal sudah ada (old value)
        @if(old('tanggal'))
            tanggalInput.dispatchEvent(new Event('change'));
        @endif
    </script>
</x-app-layout>