<nav x-data="{ open: false }" class="bg-[#111] border-b-2 border-[#EAB308] relative z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20">
            <div class="flex items-center justify-between w-full">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="text-[#EAB308] text-2xl font-bold tracking-tight">
                        Mr. Brokker
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex items-center">
                    <a href="{{ url('/') }}" class="text-gray-400 hover:text-white text-sm font-medium transition">Home</a>
                    
                    <a href="{{ route('booking.create') }}" class="{{ request()->routeIs('booking.create') ? 'text-[#EAB308] font-bold' : 'text-white hover:text-[#EAB308]' }} text-sm transition">
                        Booking
                    </a>
                    
                    <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'text-[#EAB308] font-bold' : 'text-white hover:text-[#EAB308]' }} text-sm transition">
                        Cek Status
                    </a>

                    <!-- Dropdown User -->
                    <!-- Navigasi Dropdown Manual (Anti-Putih) -->
<div class="ml-3 relative" x-data="{ open: false }">
    <!-- Tombol Nama -->
    <button @click="open = !open" @click.away="open = false" class="flex items-center text-sm font-medium text-[#EAB308] border border-[#EAB308]/50 px-3 py-1 rounded-lg hover:bg-[#EAB308]/10 transition focus:outline-none">
        <div>{{ Auth::user()->name }}</div>
        <div class="ml-1">
            <svg class="fill-current h-4 w-4 transition-transform duration-200" :class="{'rotate-180': open}" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
            </svg>
        </div>
    </button>

    <!-- Panel Logout Murni (Tanpa x-dropdown) -->
    <div x-show="open" 
         x-transition:enter="transition ease-out duration-100"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-75"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-[#111] border border-[#EAB308]/50 z-50" 
         style="display: none;">
        
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="block w-full text-center px-4 py-3 text-sm font-bold text-white hover:bg-[#EAB308] hover:text-black transition-colors duration-200">
                KELUAR AKUN
            </button>
        </form>
    </div>
</div>
                </div>
            </div>
        </div>
    </div>
</nav>