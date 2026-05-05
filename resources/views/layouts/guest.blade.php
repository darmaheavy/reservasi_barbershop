<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Mr. Brokker - Login</title>
        <!-- Tailwind CDN -->
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="bg-[#121212] font-sans antialiased text-white">
        <!-- Navbar Sesuai Mockup -->
        <nav class="flex items-center justify-between px-12 py-6 border-b border-[#EAB308]">
            <div class="text-[#EAB308] text-3xl font-bold">Mr. Brokker</div>
            <div class="flex space-x-8 text-white font-medium">
                <a href="{{ url('/') }}" class="hover:text-[#EAB308]">Home</a>
                <a href="#" class="hover:text-[#EAB308]">Layanan</a>
                <a href="#" class="hover:text-[#EAB308]">Galeri</a>
                <a href="#" class="hover:text-[#EAB308]">Booking</a>
                <a href="#" class="hover:text-[#EAB308]">Cek Status</a>
                <a href="#" class="hover:text-[#EAB308]">Alamat</a>
            </div>
        </nav>

        <div class="min-h-[80vh] flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
            <div class="w-full sm:max-w-md mt-6 px-10 py-12 bg-[#1C1C1C] border border-[#EAB308] shadow-lg rounded-[30px]">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>