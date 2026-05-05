<x-guest-layout>
    {{-- Session Status --}}
    @if (session('status'))
        <div class="mb-4 text-sm text-green-400 text-center">
            {{ session('status') }}
        </div>
    @endif

    {{-- Validation Errors --}}
    @if ($errors->any())
        <div class="mb-4 text-sm text-red-400 text-center">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <!-- Title -->
    <div class="text-center mb-8">
        <div class="flex items-center justify-center gap-3 mb-4">
            <div class="w-10 h-10 bg-[#EAB308] rounded-lg flex items-center justify-center">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#000" stroke-width="2.5" stroke-linecap="round">
                    <path d="M6 3L6 21M18 3L18 21M6 7L18 7M6 17L18 17"/>
                </svg>
            </div>
            <span class="text-white font-bold text-xl" style="font-family:'Playfair Display',serif;">Mr. Brokker</span>
        </div>
        <h2 class="text-[#EAB308] text-3xl font-bold" style="font-family:'Playfair Display',serif;">Masuk</h2>
        <p class="text-gray-500 text-sm mt-1">Selamat datang kembali</p>
    </div>

    <!-- Social Login Buttons -->
    <div class="space-y-3 mb-6">
        <button type="button" class="w-full flex items-center justify-center gap-3 border border-gray-700 rounded-xl py-2.5 hover:border-[#EAB308] hover:bg-[#EAB308]/5 transition text-sm text-gray-300 hover:text-white">
            <img src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg" class="w-5 h-5" alt="Google">
            Continue with Google
        </button>
        <button type="button" class="w-full flex items-center justify-center gap-3 border border-gray-700 rounded-xl py-2.5 hover:border-[#EAB308] hover:bg-[#EAB308]/5 transition text-sm text-gray-300 hover:text-white">
            <svg class="w-5 h-5 text-blue-500" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
            Continue with Facebook
        </button>
        <button type="button" class="w-full flex items-center justify-center gap-3 border border-gray-700 rounded-xl py-2.5 hover:border-[#EAB308] hover:bg-[#EAB308]/5 transition text-sm text-gray-300 hover:text-white">
            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M12.152 6.896c-.948 0-2.415-1.078-3.96-1.04-2.04.027-3.91 1.183-4.961 3.014-2.117 3.675-.546 9.103 1.519 12.09 1.013 1.454 2.208 3.09 3.792 3.039 1.52-.065 2.09-.987 3.935-.987 1.831 0 2.35.987 3.96.948 1.637-.026 2.676-1.48 3.676-2.948 1.156-1.688 1.636-3.325 1.662-3.415-.039-.013-3.182-1.221-3.22-4.857-.026-3.04 2.48-4.494 2.597-4.559-1.429-2.09-3.623-2.324-4.39-2.376-2-.156-3.675 1.09-4.61 1.09zM15.53 3.83c.843-1.012 1.4-2.427 1.245-3.83-1.207.052-2.662.805-3.532 1.818-.78.896-1.454 2.338-1.273 3.714 1.338.104 2.715-.688 3.559-1.701z"/></svg>
            Continue with Apple
        </button>
    </div>

    <!-- Divider -->
    <div class="relative flex items-center mb-6">
        <div class="flex-grow border-t border-gray-800"></div>
        <span class="flex-shrink mx-4 text-gray-600 text-xs tracking-widest uppercase">atau</span>
        <div class="flex-grow border-t border-gray-800"></div>
    </div>

    <!-- Login Form -->
    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email -->
        <div class="mb-4">
            <label for="email" class="block text-gray-400 text-xs font-semibold mb-2 uppercase tracking-wider">Email</label>
            <input
                id="email"
                type="email"
                name="email"
                value="{{ old('email') }}"
                required
                autofocus
                autocomplete="username"
                placeholder="coba@gmail.com"
                class="w-full bg-[#111] border border-gray-700 rounded-xl py-3 px-4 text-white text-sm placeholder-gray-600
                       focus:outline-none focus:border-[#EAB308] focus:ring-1 focus:ring-[#EAB308]/30 transition"
            >
        </div>

        <!-- Password -->
        <div class="mb-2">
            <label for="password" class="block text-gray-400 text-xs font-semibold mb-2 uppercase tracking-wider">Password</label>
            <div class="relative">
                <input
                    id="password"
                    type="password"
                    name="password"
                    required
                    autocomplete="current-password"
                    placeholder="••••••••"
                    class="w-full bg-[#111] border border-gray-700 rounded-xl py-3 px-4 text-white text-sm placeholder-gray-600
                           focus:outline-none focus:border-[#EAB308] focus:ring-1 focus:ring-[#EAB308]/30 transition pr-11"
                >
                <!-- Toggle password visibility -->
                <button type="button" onclick="togglePassword()" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-[#EAB308] transition">
                    <svg id="eye-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                        <circle cx="12" cy="12" r="3"/>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Remember me + Forgot password -->
        <div class="flex items-center justify-between mb-6 mt-3">
            <label class="flex items-center gap-2 cursor-pointer">
                <input type="checkbox" name="remember" class="w-4 h-4 rounded border-gray-700 bg-[#111] accent-[#EAB308]">
                <span class="text-gray-500 text-xs">Ingat saya</span>
            </label>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-xs text-[#EAB308] hover:underline">
                    Lupa password?
                </a>
            @endif
        </div>

        <!-- Submit Button -->
        <button
            type="submit"
            class="w-full bg-[#EAB308] text-black font-bold py-3 px-4 rounded-xl text-sm
                   hover:bg-yellow-400 active:scale-[0.98] transition-all duration-150
                   flex items-center justify-center gap-2"
        >
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
                <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/>
                <polyline points="10 17 15 12 10 7"/>
                <line x1="15" y1="12" x2="3" y2="12"/>
            </svg>
            Masuk
        </button>

        <!-- Register link -->
        <p class="text-center text-gray-600 text-xs mt-5">
            Belum punya akun?
            <a href="{{ route('register') }}" class="text-[#EAB308] hover:underline font-semibold">Daftar di sini</a>
        </p>
    </form>

    <script>
        function togglePassword() {
            const input = document.getElementById('password');
            const icon = document.getElementById('eye-icon');
            if (input.type === 'password') {
                input.type = 'text';
                icon.innerHTML = `<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/>`;
            } else {
                input.type = 'password';
                icon.innerHTML = `<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>`;
            }
        }
    </script>
</x-guest-layout>