<x-app-layout>
    <div class="min-h-screen bg-[#0c0c0c] text-white font-sans py-12">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="bg-[#111] border-2 border-[#EAB308]/50 rounded-[40px] p-8 md:p-12 shadow-[0_0_50px_rgba(234,179,8,0.1)]">
                
                <div class="text-center mb-10">
                    <h2 class="text-[#EAB308] text-3xl font-bold uppercase tracking-widest">Booking Sekarang</h2>
                </div>

                <!-- ✅ SUCCESS -->
                @if(session('success'))
                    <div class="mb-6 p-4 bg-green-500/20 border border-green-500 text-green-300 rounded-xl">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- ❌ ERROR -->
                @if ($errors->any())
                    <div class="mb-6 p-4 bg-red-500/20 border border-red-500 text-red-300 rounded-xl">
                        <ul class="list-disc pl-5 text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- FORM -->
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
                            
                            <option value="">--Pilih Layanan--</option>
                            <option value="Haircut" {{ old('layanan') == 'Haircut' ? 'selected' : '' }}>Haircut - Rp 50k</option>
                            <option value="Beard Trim" {{ old('layanan') == 'Beard Trim' ? 'selected' : '' }}>Beard Trim - Rp 30k</option>
                            <option value="Full Service" {{ old('layanan') == 'Full Service' ? 'selected' : '' }}>Full Service - Rp 75k</option>
                        </select>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Tanggal -->
                        <div>
                            <label class="block text-sm font-bold text-gray-300 mb-2">Tanggal</label>
                            <input type="date" name="tanggal" 
                                value="{{ old('tanggal') }}" required
                                class="w-full bg-[#1c1c1c] border border-gray-700 rounded-xl px-4 py-3 text-white focus:border-[#EAB308] focus:ring-1 focus:ring-[#EAB308] transition color-scheme-dark">
                        </div>

                        <!-- Jam -->
                        <div>
                            <label class="block text-sm font-bold text-gray-300 mb-2">Jam</label>
                            <input type="time" name="jam" 
                                value="{{ old('jam') }}" required
                                class="w-full bg-[#1c1c1c] border border-gray-700 rounded-xl px-4 py-3 text-white focus:border-[#EAB308] focus:ring-1 focus:ring-[#EAB308] transition color-scheme-dark">
                        </div>
                    </div>

                    <!-- WhatsApp -->
                    <div>
                        <label class="block text-sm font-bold text-gray-300 mb-2">Nomor WhatsApp</label>
                        <input type="text" name="whatsapp" 
                            value="{{ old('whatsapp') }}" required
                            class="w-full bg-[#1c1c1c] border border-gray-700 rounded-xl px-4 py-3 text-white focus:border-[#EAB308] focus:ring-1 focus:ring-[#EAB308] transition"
                            placeholder="Masukkan nomor WhatsApp Anda">
                    </div>

                    <!-- Tombol -->
                    <div class="pt-6 space-y-3">
                        <button type="submit" 
                            class="w-full bg-[#EAB308] text-black font-black uppercase tracking-widest py-4 rounded-2xl hover:bg-yellow-500 hover:scale-[1.02] transition-all shadow-lg shadow-yellow-600/20">
                            Booking Sekarang
                        </button>

                        <!-- 🔥 tombol ke halaman status -->
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
        .color-scheme-dark::-webkit-calendar-picker-indicator {
            filter: invert(1);
        }
    </style>
</x-app-layout>