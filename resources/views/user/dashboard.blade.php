<x-app-layout>
    <div class="min-h-screen bg-[#0c0c0c] text-white font-sans">
        
        <!-- Header / Hero Section Ala Figma -->
        <div class="relative bg-[#111] border-b border-[#EAB308]/30 py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h1 class="text-[#EAB308] text-4xl md:text-5xl font-bold mb-4">
                    Selamat Datang di Mr. Brokker Barbershop
                </h1>
                <p class="text-gray-400 text-lg max-w-2xl mx-auto mb-8">
                    Gaya maskulin, presisi, dan elegan untuk pria sejati.
                </p>
               
                <!-- Jika Belum Ada Reservasi (Empty State ala Button Figma) -->
               @if(!$res)
                <a href="{{ route('booking.create') }}"
                class="bg-[#EAB308] text-black px-10 py-4 rounded-full font-bold">
                    Reservasi Sekarang
                </a>
            @endif
            </div>
        </div>

        <!-- Dashboard Content -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            
            @if($res)
                <!-- Notifikasi Status (Sesuai Permintaan Temanmu) -->
                @if($res->status == 'confirmed')
                    <div class="mb-10 bg-[#EAB308]/10 border border-[#EAB308] p-6 rounded-2xl flex items-center justify-between animate-pulse">
                        <div class="flex items-center space-x-4">
                            <div class="bg-[#EAB308] p-2 rounded-lg">
                                <svg class="w-6 h-6 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <div>
                                <h3 class="text-[#EAB308] font-bold text-lg">Reservasi Terkonfirmasi!</h3>
                                <p class="text-gray-400 text-sm">Admin sudah menyetujui jadwal potong rambutmu.</p>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Card Status Utama Ala Box "Kenapa Memilih Kami" -->
                <div class="grid grid-cols-1 md:grid-cols-1 gap-8">
                    <div class="bg-[#111] border-2 border-[#EAB308] rounded-[30px] p-8 md:p-12 relative overflow-hidden">
                        <!-- Aksesori Garis Emas Samping -->
                        <div class="absolute top-0 left-0 w-2 h-full bg-[#EAB308]"></div>
                        
                        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-8">
                            <div>
                                <h2 class="text-[#EAB308] text-sm font-black uppercase tracking-[0.3em] mb-4">Status Reservasi Anda</h2>
                                <h3 class="text-4xl font-bold mb-2">{{ $res->service }}</h3>
                                <p class="text-gray-500 flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    {{ \Carbon\Carbon::parse($res->date)->format('d F Y') }} — {{ $res->time }} WITA
                                </p>
                            </div>

                            <div class="flex flex-col items-center md:items-end">
                                <div class="px-8 py-3 rounded-xl border-2 font-black uppercase tracking-widest text-xl
                                    {{ $res->status == 'pending' ? 'border-yellow-600 text-yellow-600 bg-yellow-600/10' : 'border-green-500 text-green-500 bg-green-500/10' }}">
                                    {{ $res->status }}
                                </div>
                                <p class="text-gray-600 text-xs mt-3 italic text-center">ID Transaksi: #MBR-{{ $res->id }}</p>
                            </div>
                        </div>
                    </div>
                </div>

            @else
                <!-- Empty State (Jika Akun Baru) -->
                <div class="text-center py-20 bg-[#111] border-2 border-dashed border-[#EAB308]/20 rounded-[40px]">
                    <p class="text-gray-500 text-lg italic mb-6">"Belum ada riwayat reservasi yang tercatat."</p>
                    <p class="text-[#EAB308] font-medium">Silakan lakukan booking untuk menikmati layanan kami.</p>
                </div>
            @endif

            <!-- Section Bawah (Mirip Box Informasi di Figma) -->
            <div class="mt-16 grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-[#111] border border-[#EAB308]/30 p-8 rounded-[25px] text-center hover:border-[#EAB308] transition-colors">
                    <h4 class="text-[#EAB308] font-bold mb-2 uppercase tracking-widest text-xs">Profesional</h4>
                    <p class="text-gray-400 text-sm">Stylist berpengalaman yang ahli berbagai gaya rambut.</p>
                </div>
                <div class="bg-[#111] border border-[#EAB308]/30 p-8 rounded-[25px] text-center hover:border-[#EAB308] transition-colors">
                    <h4 class="text-[#EAB308] font-bold mb-2 uppercase tracking-widest text-xs">Cepat & Tepat</h4>
                    <p class="text-gray-400 text-sm">Reservasi online cepat, tidak perlu antre lama di lokasi.</p>
                </div>
                <div class="bg-[#111] border border-[#EAB308]/30 p-8 rounded-[25px] text-center hover:border-[#EAB308] transition-colors">
                    <h4 class="text-[#EAB308] font-bold mb-2 uppercase tracking-widest text-xs">Nyaman</h4>
                    <p class="text-gray-400 text-sm">Tempat bersih & nyaman untuk pengalaman terbaik.</p>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>