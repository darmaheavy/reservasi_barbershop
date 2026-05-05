<x-app-layout>
    <div class="min-h-screen bg-[#0c0c0c] text-white py-12">
        <div class="max-w-4xl mx-auto px-4">

            <h2 class="text-2xl font-bold mb-6 text-[#EAB308]">Status Booking</h2>

            <!-- ✅ SUCCESS -->
            @if(session('success'))
                <div class="mb-6 p-4 bg-green-500/20 border border-green-500 text-green-300 rounded-xl">
                    {{ session('success') }}
                </div>
            @endif

            <!-- TABLE -->
            <div class="bg-[#111] rounded-2xl overflow-hidden border border-gray-700">
                <table class="w-full text-sm text-center">
                    <thead class="bg-[#EAB308] text-black">
                        <tr>
                            <th class="p-3">Nama</th>
                            <th class="p-3">Layanan</th>
                            <th class="p-3">Tanggal</th>
                            <th class="p-3">Jam</th>
                            <th class="p-3">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($bookings as $b)
                            <tr class="border-t border-gray-700">
                                <td class="p-3">{{ $b->nama }}</td>
                                <td class="p-3">{{ $b->layanan }}</td>
                                <td class="p-3">{{ $b->tanggal }}</td>
                                <td class="p-3">{{ $b->jam }}</td>
                                <td class="p-3">
                                    @if($b->status == 'pending')
                                        <span class="text-yellow-400 font-bold">Pending</span>
                                    @elseif($b->status == 'selesai')
                                        <span class="text-green-400 font-bold">Selesai</span>
                                    @else
                                        <span class="text-red-400 font-bold">{{ $b->status }}</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-4 text-gray-400">
                                    Belum ada booking
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- 🔥 BUTTON KEMBALI -->
            <div class="mt-6 text-center">
                <a href="{{ route('booking.create') }}"
                    class="inline-block px-6 py-3 bg-[#EAB308] text-black font-bold rounded-xl hover:bg-yellow-500 transition">
                    Booking Lagi
                </a>
            </div>

        </div>
    </div>
</x-app-layout>
