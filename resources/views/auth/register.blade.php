<x-guest-layout>
    <div class="text-center mb-8">
        <h2 class="text-[#EAB308] text-4xl font-bold">Register</h2>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name (Username di Mockup) -->
        <div class="mb-5">
            <label class="block text-white text-sm font-bold mb-2">Username</label>
            <input type="text" name="name" :value="old('name')" placeholder="Masukkan nama Anda" 
                class="w-full bg-transparent border border-gray-600 rounded-full py-3 px-6 text-gray-300 focus:outline-none focus:border-[#EAB308]" required autofocus>
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email -->
        <div class="mb-5">
            <label class="block text-white text-sm font-bold mb-2">Email</label>
            <input type="email" name="email" :value="old('email')" placeholder="Masukkan email Anda" 
                class="w-full bg-transparent border border-gray-600 rounded-full py-3 px-6 text-gray-300 focus:outline-none focus:border-[#EAB308]" required>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mb-5">
            <label class="block text-white text-sm font-bold mb-2">Password</label>
            <input type="password" name="password" placeholder="Masukkan password Anda" 
                class="w-full bg-transparent border border-gray-600 rounded-full py-3 px-6 text-gray-300 focus:outline-none focus:border-[#EAB308]" required autocomplete="new-password">
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password (Sembunyi/Hidden) -->
        <!-- Karena di mockup tidak ada, kita samakan isinya secara otomatis lewat script atau biarkan input tersembunyi agar validasi Laravel tidak error -->
        <input type="hidden" name="password_confirmation" id="password_confirmation">

        <div class="flex flex-col items-center mt-4">
            <p class="text-[10px] text-gray-400 self-start ml-2 mb-6">
                Sudah punya akun? <a href="{{ route('login') }}" class="text-blue-500 hover:underline">Login</a>
            </p>

            <button type="submit" class="bg-[#FAB005] hover:bg-[#e19d00] text-black font-bold py-3 px-16 rounded-full transition duration-300 shadow-lg uppercase tracking-wider">
                Submit
            </button>
        </div>
    </form>

    <script>
        // Script sederhana agar konfirmasi password otomatis sama dengan password utama
        const pwd = document.querySelector('input[name="password"]');
        const pwdConfirm = document.querySelector('input[name="password_confirmation"]');
        pwd.addEventListener('input', () => {
            pwdConfirm.value = pwd.value;
        });
    </script>
</x-guest-layout>