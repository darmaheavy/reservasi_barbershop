<x-app-layout>
    <div class="min-h-screen bg-[#0c0c0c] text-white py-12">
        <div class="max-w-4xl mx-auto px-4">

            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-[#EAB308]">Riwayat Booking Saya</h2>
                <span class="bg-gray-800 px-3 py-1 rounded-full text-xs text-gray-400">
                    Total: {{ $bookings->count() }} Data
                </span>
            </div>

            @if(session('success'))
                <div class="mb-6 p-4 bg-green-500/20 border border-green-500 text-green-300 rounded-xl">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-[#111] rounded-2xl overflow-hidden border border-gray-800 shadow-xl">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-[#EAB308] text-black">
                            <tr>
                                <th class="p-4">Layanan</th>
                                <th class="p-4">Tanggal</th>
                                <th class="p-4">Jam</th>
                                <th class="p-4">WhatsApp</th>
                                <th class="p-4 text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-800">
                            @forelse ($bookings as $b)
                                <tr class="hover:bg-white/5 transition">
                                    <td class="p-4">
                                        <p class="font-bold text-white">{{ $b->layanan }}</p>
                                        <p class="text-xs text-gray-500">{{ $b->nama }}</p>
                                    </td>
                                    <td class="p-4 text-gray-300">
                                        {{ \Carbon\Carbon::parse($b->tanggal)->format('d M Y') }}
                                    </td>
                                    <td class="p-4 text-gray-300">{{ $b->jam }}</td>
                                    <td class="p-4 text-gray-400 text-xs">{{ $b->whatsapp }}</td>
                                    <td class="p-4 text-center">
                                        @if($b->status == 'pending')
                                            <span class="bg-yellow-500/10 text-yellow-500 border border-yellow-500/20 px-3 py-1 rounded-full text-xs font-bold">
                                                Menunggu
                                            </span>
                                        @elseif($b->status == 'confirmed')
                                            <span class="bg-green-500/10 text-green-500 border border-green-500/20 px-3 py-1 rounded-full text-xs font-bold">
                                                Dikonfirmasi
                                            </span>
                                        @elseif($b->status == 'cancelled')
                                            <span class="bg-red-500/10 text-red-500 border border-red-500/20 px-3 py-1 rounded-full text-xs font-bold">
                                                Dibatalkan
                                            </span>
                                        @else
                                            <span class="bg-gray-500/10 text-gray-500 border border-gray-500/20 px-3 py-1 rounded-full text-xs font-bold">
                                                {{ ucfirst($b->status) }}
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="p-12 text-center text-gray-500">
                                        <div class="flex flex-col items-center">
                                            <svg class="w-12 h-12 mb-3 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                            </svg>
                                            <p>Kamu belum memiliki riwayat booking.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-8 flex justify-center">
                <a href="{{ route('booking.create') }}"
                    class="px-8 py-3 bg-[#EAB308] text-black font-black uppercase tracking-widest rounded-xl hover:bg-yellow-500 hover:scale-105 transition shadow-lg shadow-yellow-600/20">
                    Booking Lagi
                </a>
            </div>

        </div>
    </div>
</x-app-layout>