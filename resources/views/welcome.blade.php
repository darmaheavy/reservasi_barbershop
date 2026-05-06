<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mr. Brokker Barbershop</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/glightbox/3.3.0/css/glightbox.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'DM Sans', sans-serif; }
        h1, h2, h3, .font-display { font-family: 'Playfair Display', serif; }
        .gold { color: #EAB308; }
        .bg-dark { background-color: #0e0e0e; }
        .bg-card { background-color: #1a1a1a; }
        .bg-card2 { background-color: #222222; }
        .border-gold { border-color: #EAB308; }
        .hero-bg {
            background: linear-gradient(to bottom, rgba(0,0,0,0.55) 0%, rgba(0,0,0,0.75) 100%),
                        url('https://images.unsplash.com/photo-1503951914875-452162b0f3f1?w=1600') center/cover no-repeat;
        }
        .gold-underline::after {
            content: '';
            display: block;
            width: 60px;
            height: 3px;
            background: #EAB308;
            margin: 12px auto 0;
        }
        .service-card {
            background: #1a1a1a;
            border: 1px solid #2a2a2a;
            border-radius: 16px;
            transition: all 0.3s ease;
        }
        .service-card:hover {
            border-color: #EAB308;
            transform: translateY(-4px);
            background: #222;
        }
        .icon-box {
            width: 48px; height: 48px;
            background: rgba(234,179,8,0.12);
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
        }
        .review-card {
            background: #1a1a1a;
            border: 1px solid #2a2a2a;
            border-radius: 16px;
        }
        .info-card {
            background: #1a1a1a;
            border: 1px solid #2a2a2a;
            border-radius: 12px;
            padding: 1.5rem;
            display: flex;
            align-items: flex-start;
            gap: 1rem;
        }
        .hamburger-line { transition: all 0.3s ease; }
        .hamburger.open .line1 { transform: rotate(45deg) translate(5px, 5px); }
        .hamburger.open .line2 { opacity: 0; }
        .hamburger.open .line3 { transform: rotate(-45deg) translate(5px, -5px); }
        .gallery-img { transition: transform 0.4s ease; }
        .gallery-img:hover { transform: scale(1.05); }
        .stat-card {
            background: rgba(234,179,8,0.08);
            border: 1px solid rgba(234,179,8,0.2);
            border-radius: 12px;
            padding: 1.5rem;
            text-align: center;
        }
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #0e0e0e; }
        ::-webkit-scrollbar-thumb { background: #EAB308; border-radius: 3px; }
    </style>
</head>
<body class="bg-dark text-white scroll-smooth">

    <!-- ═══════════════════════════════════════════ NAVBAR ══ -->
    <nav id="navbar" class="fixed top-0 w-full z-50 transition-all duration-300" style="background: rgba(14,14,14,0.95); backdrop-filter: blur(12px); border-bottom: 1px solid rgba(234,179,8,0.2);">
        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">

            <!-- Logo -->
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-[#EAB308] rounded-lg flex items-center justify-center">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#000" stroke-width="2.5" stroke-linecap="round">
                        <path d="M6 3L6 21M18 3L18 21M6 7L18 7M6 17L18 17"/>
                    </svg>
                </div>
                <span class="text-white font-bold text-xl" style="font-family:'Playfair Display',serif;">Mr. Brokker</span>
            </div>

            <!-- Desktop Menu -->
            <div class="hidden md:flex items-center space-x-8 text-sm font-medium">
                <a href="#tentang" class="text-gray-300 hover:text-[#EAB308] transition">Tentang</a>
                <a href="#layanan" class="text-gray-300 hover:text-[#EAB308] transition">Layanan</a>
                <a href="#galeri" class="text-gray-300 hover:text-[#EAB308] transition">Galeri</a>
                <a href="#ulasan" class="text-gray-300 hover:text-[#EAB308] transition">Ulasan</a>
                <a href="#lokasi" class="text-gray-300 hover:text-[#EAB308] transition">Lokasi</a>
            </div>

            <!-- Auth + Hamburger -->
            <div class="flex items-center gap-3">
    @if (Route::has('login'))
        @auth
            @if(auth()->user()->role === 'admin')
                <a href="{{ route('admin.dashboard') }}" class="text-sm border border-[#EAB308] px-4 py-2 rounded-lg text-[#EAB308] hover:bg-[#EAB308] hover:text-black transition font-medium">Dashboard Admin</a>
            @else
                <a href="{{ url('/dashboard') }}" class="text-sm border border-[#EAB308] px-4 py-2 rounded-lg text-[#EAB308] hover:bg-[#EAB308] hover:text-black transition font-medium">Dashboard</a>
            @endif
        @else
            <a href="{{ route('login') }}" class="hidden md:block text-sm text-gray-300 hover:text-white px-4 py-2 transition">Masuk</a>
            <a href="{{ route('register') }}" class="text-sm bg-[#EAB308] text-black px-5 py-2 rounded-lg font-bold hover:bg-yellow-400 transition">Daftar</a>
        @endauth
    @endif

                <!-- Hamburger -->
                <button id="hamburger" class="hamburger md:hidden flex flex-col justify-center items-center w-9 h-9 gap-1.5">
                    <span class="line1 hamburger-line block w-5 h-0.5 bg-white"></span>
                    <span class="line2 hamburger-line block w-5 h-0.5 bg-white"></span>
                    <span class="line3 hamburger-line block w-5 h-0.5 bg-white"></span>
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden md:hidden px-6 pb-6 space-y-3 border-t border-gray-800 pt-4">
            <a href="#tentang" class="block text-gray-300 hover:text-[#EAB308] py-1">Tentang</a>
            <a href="#layanan" class="block text-gray-300 hover:text-[#EAB308] py-1">Layanan</a>
            <a href="#galeri" class="block text-gray-300 hover:text-[#EAB308] py-1">Galeri</a>
            <a href="#ulasan" class="block text-gray-300 hover:text-[#EAB308] py-1">Ulasan</a>
            <a href="#lokasi" class="block text-gray-300 hover:text-[#EAB308] py-1">Lokasi</a>
            @if (Route::has('login'))
                @guest
                    <a href="{{ route('login') }}" class="block text-gray-300 hover:text-white py-1">Masuk</a>
                @endguest
            @endif
        </div>
    </nav>

    <!-- ═══════════════════════════════════════════ HERO ══ -->
    <section id="home" class="hero-bg min-h-screen flex flex-col items-center justify-center text-center px-6 pt-20">
        <div data-aos="fade-down" data-aos-duration="600" class="inline-block border border-[#EAB308] text-[#EAB308] text-xs font-semibold tracking-widest uppercase px-5 py-2 rounded-full mb-6">
            Barbershop Premium
        </div>
        <h1 data-aos="fade-up" data-aos-duration="700" class="text-5xl md:text-7xl font-black text-white mb-4 leading-tight" style="font-family:'Playfair Display',serif;">
            Mr. Brokker<br>Barbershop
        </h1>
        <p data-aos="fade-up" data-aos-delay="100" data-aos-duration="700" class="text-[#EAB308] text-xl md:text-2xl font-semibold mb-4" style="font-family:'Playfair Display',serif;">
            Gaya Presisi. Tukang Cukur Nyata. Warisan Lokal.
        </p>
        <p data-aos="fade-up" data-aos-delay="200" class="text-gray-300 text-base md:text-lg mb-10 max-w-xl">
            Barbershop berorientasi keluarga yang dikenal dengan potongan presisi, energi positif, dan pelanggan setia bertahun-tahun.
        </p>
        <div data-aos="fade-up" data-aos-delay="300" class="flex flex-col sm:flex-row gap-4">
            <a href="{{ route('register') }}" class="flex items-center gap-2 bg-[#EAB308] text-black font-bold py-4 px-8 rounded-xl text-base hover:bg-yellow-400 transition hover:scale-105">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
                Buat Janji
            </a>
            <a href="#lokasi" class="flex items-center gap-2 bg-transparent border border-white/40 text-white font-semibold py-4 px-8 rounded-xl text-base hover:border-white transition">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/><circle cx="12" cy="9" r="2.5"/></svg>
                Kunjungi Toko
            </a>
        </div>
        <div data-aos="fade-up" data-aos-delay="400" class="mt-16 flex gap-10 text-center">
            <div><div class="text-[#EAB308] text-3xl font-bold" style="font-family:'Playfair Display',serif;">5+</div><div class="text-gray-400 text-sm mt-1">Tahun Berpengalaman</div></div>
            <div class="border-l border-gray-700"></div>
            <div><div class="text-[#EAB308] text-3xl font-bold" style="font-family:'Playfair Display',serif;">500+</div><div class="text-gray-400 text-sm mt-1">Pelanggan Puas</div></div>
            <div class="border-l border-gray-700"></div>
            <div><div class="text-[#EAB308] text-3xl font-bold" style="font-family:'Playfair Display',serif;">4.9★</div><div class="text-gray-400 text-sm mt-1">Rating Pelanggan</div></div>
        </div>
        <div class="mt-16 animate-bounce">
            <div class="w-6 h-10 border-2 border-[#EAB308] rounded-full flex items-start justify-center p-1 mx-auto">
                <div class="w-1 h-2 bg-[#EAB308] rounded-full"></div>
            </div>
        </div>
    </section>

    <!-- ═══════════════════════════════════════════ LAYANAN ══ -->
    <section id="layanan" class="py-24 px-6" style="background:#111;">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-16">
                <p data-aos="fade-up" class="text-[#EAB308] text-sm font-semibold tracking-widest uppercase mb-3">Apa yang Kami Tawarkan</p>
                <h2 data-aos="fade-up" data-aos-delay="100" class="text-4xl md:text-5xl font-bold gold-underline" style="font-family:'Playfair Display',serif;">Layanan Kami</h2>
                <p data-aos="fade-up" data-aos-delay="200" class="text-gray-400 mt-6 max-w-lg mx-auto">Layanan grooming berkualitas yang disesuaikan dengan gaya dan preferensi Anda.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div data-aos="fade-up" data-aos-delay="0" class="service-card p-8">
                    <div class="icon-box mb-5">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#EAB308" stroke-width="2"><path d="M6 3L6 21M18 3L18 21M6 7L18 7M6 17L18 17"/></svg>
                    </div>
                    <h3 class="text-white text-xl font-bold mb-2">Potong Rambut</h3>
                    <p class="text-gray-400 text-sm mb-4">Potongan klasik, gaya modern, dan segala sesuatu di antaranya.</p>
                    <p class="text-[#EAB308] font-semibold">Mulai dari Rp30.000</p>
                </div>
                <div data-aos="fade-up" data-aos-delay="100" class="service-card p-8">
                    <div class="icon-box mb-5">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#EAB308" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 8v4l3 3"/></svg>
                    </div>
                    <h3 class="text-white text-xl font-bold mb-2">Skin Fade</h3>
                    <p class="text-gray-400 text-sm mb-4">Fade presisi yang menyatu sempurna dari kulit ke rambut.</p>
                    <p class="text-[#EAB308] font-semibold">Mulai dari Rp35.000</p>
                </div>
                <div data-aos="fade-up" data-aos-delay="200" class="service-card p-8">
                    <div class="icon-box mb-5">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#EAB308" stroke-width="2"><path d="M12 2l3 7h7l-5.5 4 2 7L12 16l-6.5 4 2-7L2 9h7z"/></svg>
                    </div>
                    <h3 class="text-white text-xl font-bold mb-2">Cukur Jenggot</h3>
                    <p class="text-gray-400 text-sm mb-4">Bentuk, rapikan, dan tata jenggot Anda hingga sempurna.</p>
                    <p class="text-[#EAB308] font-semibold">Mulai dari Rp20.000</p>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div data-aos="fade-up" data-aos-delay="100" class="service-card p-8">
                    <div class="icon-box mb-5">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#EAB308" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    </div>
                    <h3 class="text-white text-xl font-bold mb-2">Potongan Anak</h3>
                    <p class="text-gray-400 text-sm mb-4">Layanan ramah dan sabar untuk si kecil.</p>
                    <p class="text-[#EAB308] font-semibold">Mulai dari Rp25.000</p>
                </div>
                <div data-aos="fade-up" data-aos-delay="200" class="service-card p-8">
                    <div class="icon-box mb-5">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#EAB308" stroke-width="2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/></svg>
                    </div>
                    <h3 class="text-white text-xl font-bold mb-2">Paket Combo</h3>
                    <p class="text-gray-400 text-sm mb-4">Paket potong rambut + cukur jenggot untuk tampilan lengkap.</p>
                    <p class="text-[#EAB308] font-semibold">Mulai dari Rp45.000</p>
                </div>
            </div>

            <!-- Stats -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-12">
                <div data-aos="fade-up" class="stat-card">
                    <div class="text-[#EAB308] text-3xl font-bold mb-1" style="font-family:'Playfair Display',serif;">5+</div>
                    <div class="text-white font-semibold mb-1">Tahun Pengalaman</div>
                    <div class="text-gray-400 text-sm">Dipercaya komunitas untuk layanan terbaik</div>
                </div>
                <div data-aos="fade-up" data-aos-delay="100" class="stat-card">
                    <div class="text-[#EAB308] text-3xl font-bold mb-1" style="font-family:'Playfair Display',serif;">✓</div>
                    <div class="text-white font-semibold mb-1">Ramah Keluarga</div>
                    <div class="text-gray-400 text-sm">Suasana nyaman untuk semua usia</div>
                </div>
                <div data-aos="fade-up" data-aos-delay="200" class="stat-card">
                    <div class="text-[#EAB308] text-3xl font-bold mb-1" style="font-family:'Playfair Display',serif;">✂</div>
                    <div class="text-white font-semibold mb-1">Barber Profesional</div>
                    <div class="text-gray-400 text-sm">Ahli yang siap melayani setiap saat</div>
                </div>
            </div>
        </div>
    </section>

    <!-- ═══════════════════════════════════════════ TENTANG ══ -->
    <section id="tentang" class="py-24 px-6 bg-dark">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-16">
                <h2 data-aos="fade-up" class="text-4xl md:text-5xl font-bold gold-underline" style="font-family:'Playfair Display',serif;">Lebih dari Sekedar Potong Rambut</h2>
                <p data-aos="fade-up" data-aos-delay="100" class="text-gray-400 mt-6 max-w-2xl mx-auto">
                    Mr. Brokker telah menjadi tujuan utama komunitas selama bertahun-tahun. Dikenal dengan fade tajam, potongan gunting yang rapi, dan suasana yang menyambut — para barber kami bangga dengan setiap potongan.
                </p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                <div data-aos="fade-right" class="rounded-2xl overflow-hidden aspect-[4/3]">
                    <img src="https://images.unsplash.com/photo-1621605815971-fbc98d665033?w=800" alt="Barbershop" class="w-full h-full object-cover">
                </div>
                <div data-aos="fade-left">
                    <h3 class="text-2xl font-bold text-white mb-4" style="font-family:'Playfair Display',serif;">Kisah Kami</h3>
                    <p class="text-gray-400 mb-4 leading-relaxed">
                        Mr. Brokker dibangun di atas fondasi keahlian luar biasa dan kepedulian tulus terhadap pelanggan. Tim barber profesional kami membawa keahlian bertahun-tahun, passion, dan dedikasi di setiap sesi.
                    </p>
                    <p class="text-gray-400 mb-4 leading-relaxed">
                        Kami bukan hanya tentang potong rambut. Kami tentang membangun koneksi, menciptakan kepercayaan diri, dan menjadi bagian dari rutinitas Anda.
                    </p>
                    <p class="text-gray-400 mb-8 leading-relaxed">
                        Toko kami bersih, profesional, dan penuh energi positif. Baik untuk fade segar, cukur jenggot, maupun potongan pertama si kecil — kami siap melayani.
                    </p>
                    <a href="{{ route('register') }}" class="inline-flex items-center gap-2 bg-[#EAB308] text-black font-bold py-3 px-7 rounded-xl hover:bg-yellow-400 transition">
                        Reservasi Sekarang
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- ═══════════════════════════════════════════ GALERI ══ -->
    <section id="galeri" class="py-24 px-6" style="background:#111;">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-16">
                <p data-aos="fade-up" class="text-[#EAB308] text-sm font-semibold tracking-widest uppercase mb-3">Karya Kami</p>
                <h2 data-aos="fade-up" data-aos-delay="100" class="text-4xl md:text-5xl font-bold gold-underline" style="font-family:'Playfair Display',serif;">Galeri</h2>
            </div>

            {{-- ✅ GALERI DARI DATABASE --}}
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                @forelse($galeri as $index => $item)
                <a href="{{ Storage::url($item->foto) }}"
                   class="glightbox rounded-xl overflow-hidden aspect-square block"
                   data-aos="zoom-in"
                   data-aos-delay="{{ $index * 50 }}">
                    <img src="{{ Storage::url($item->foto) }}"
                         class="w-full h-full object-cover gallery-img"
                         alt="Galeri Mr. Brokker">
                </a>
                @empty
                {{-- Fallback jika belum ada foto di database --}}
                <a href="https://images.unsplash.com/photo-1503951914875-452162b0f3f1?w=800" class="glightbox rounded-xl overflow-hidden aspect-square block" data-aos="zoom-in">
                    <img src="https://images.unsplash.com/photo-1503951914875-452162b0f3f1?w=400" class="w-full h-full object-cover gallery-img">
                </a>
                <a href="https://images.unsplash.com/photo-1621605815971-fbc98d665033?w=800" class="glightbox rounded-xl overflow-hidden aspect-square block" data-aos="zoom-in" data-aos-delay="50">
                    <img src="https://images.unsplash.com/photo-1621605815971-fbc98d665033?w=400" class="w-full h-full object-cover gallery-img">
                </a>
                <a href="https://images.unsplash.com/photo-1596178065887-1198b6148b2b?w=800" class="glightbox rounded-xl overflow-hidden aspect-square block" data-aos="zoom-in" data-aos-delay="100">
                    <img src="https://images.unsplash.com/photo-1596178065887-1198b6148b2b?w=400" class="w-full h-full object-cover gallery-img">
                </a>
                <a href="https://images.unsplash.com/photo-1605497788044-5a32c7078486?w=800" class="glightbox rounded-xl overflow-hidden aspect-square block" data-aos="zoom-in" data-aos-delay="150">
                    <img src="https://images.unsplash.com/photo-1605497788044-5a32c7078486?w=400" class="w-full h-full object-cover gallery-img">
                </a>
                <a href="https://images.unsplash.com/photo-1599351431613-18ef1fdd27e1?w=800" class="glightbox rounded-xl overflow-hidden aspect-square block" data-aos="zoom-in" data-aos-delay="200">
                    <img src="https://images.unsplash.com/photo-1599351431613-18ef1fdd27e1?w=400" class="w-full h-full object-cover gallery-img">
                </a>
                <a href="https://images.unsplash.com/photo-1622286342621-4bd786c2447c?w=800" class="glightbox rounded-xl overflow-hidden aspect-square block" data-aos="zoom-in" data-aos-delay="250">
                    <img src="https://images.unsplash.com/photo-1622286342621-4bd786c2447c?w=400" class="w-full h-full object-cover gallery-img">
                </a>
                @endforelse
            </div>

        </div>
    </section>

    <!-- ═══════════════════════════════════════════ ULASAN ══ -->
    <section id="ulasan" class="py-24 px-6 bg-dark">
        <div class="max-w-6xl mx-auto">
            <!-- Walk-in banner -->
            <div data-aos="fade-up" class="border border-[#EAB308]/30 rounded-2xl p-6 text-center mb-20" style="background: rgba(234,179,8,0.05);">
                <p class="text-lg"><span class="text-[#EAB308] font-semibold">Walk-in Diterima</span> <span class="text-white">(jika tersedia)</span></p>
                <p class="text-gray-400 text-sm mt-1">Kami menyarankan untuk menelepon terlebih dahulu atau booking online untuk memastikan giliran Anda.</p>
            </div>

            <div class="text-center mb-16">
                <h2 data-aos="fade-up" class="text-4xl md:text-5xl font-bold gold-underline" style="font-family:'Playfair Display',serif;">Kata Pelanggan Kami</h2>
                <p data-aos="fade-up" data-aos-delay="100" class="text-gray-400 mt-6">Ulasan nyata dari pelanggan setia kami</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div data-aos="flip-left" class="review-card p-6">
                    <div class="flex justify-between items-start mb-4">
                        <div class="flex gap-1">
                            @for($i = 0; $i < 5; $i++)
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="#EAB308"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                            @endfor
                        </div>
                        <span class="text-[#EAB308] text-4xl font-bold opacity-20" style="font-family:Georgia,serif;">"</span>
                    </div>
                    <p class="text-gray-300 text-sm italic mb-4">"Barbershop terbaik di kota, tidak diragukan lagi. Sudah ke sini bertahun-tahun dan tidak pernah mengecewakan. Potongan rapi setiap kali."</p>
                    <p class="text-[#EAB308] font-semibold">— Andi S.</p>
                </div>
                <div data-aos="flip-left" data-aos-delay="100" class="review-card p-6">
                    <div class="flex justify-between items-start mb-4">
                        <div class="flex gap-1">
                            @for($i = 0; $i < 5; $i++)
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="#EAB308"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                            @endfor
                        </div>
                        <span class="text-[#EAB308] text-4xl font-bold opacity-20" style="font-family:Georgia,serif;">"</span>
                    </div>
                    <p class="text-gray-300 text-sm italic mb-4">"Pelayanan sangat ramah, hasil potongan sangat rapi dan memuaskan. Booking online sangat mudah!"</p>
                    <p class="text-[#EAB308] font-semibold">— Rusdi M.</p>
                </div>
                <div data-aos="flip-left" data-aos-delay="200" class="review-card p-6">
                    <div class="flex justify-between items-start mb-4">
                        <div class="flex gap-1">
                            @for($i = 0; $i < 5; $i++)
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="#EAB308"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                            @endfor
                        </div>
                        <span class="text-[#EAB308] text-4xl font-bold opacity-20" style="font-family:Georgia,serif;">"</span>
                    </div>
                    <p class="text-gray-300 text-sm italic mb-4">"Tempat yang nyaman, barber sangat profesional. Anak saya yang biasanya susah potong rambut, di sini malah betah!"</p>
                    <p class="text-[#EAB308] font-semibold">— Budi P.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ═══════════════════════════════════════════ LOKASI ══ -->
    <section id="lokasi" class="py-24 px-6" style="background:#111;">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-16">
                <h2 data-aos="fade-up" class="text-4xl md:text-5xl font-bold gold-underline" style="font-family:'Playfair Display',serif;">Kunjungi Kami</h2>
                <p data-aos="fade-up" data-aos-delay="100" class="text-gray-400 mt-6">Singgah atau hubungi kami untuk membuat janji temu</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-start">
                <div data-aos="fade-right" class="space-y-4">
                    <div class="info-card">
                        <div class="icon-box shrink-0">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#EAB308" stroke-width="2"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/><circle cx="12" cy="9" r="2.5"/></svg>
                        </div>
                        <div>
                            <h4 class="text-white font-bold mb-1">Alamat</h4>
                            <p class="text-gray-400 text-sm leading-relaxed">Jalan Pantai Kedungu No 13, Nyitdah,<br>Kec. Kediri, Kabupaten Tabanan,<br>Bali 82121</p>
                            <a href="https://maps.google.com" target="_blank" class="text-[#EAB308] text-sm font-semibold mt-2 inline-block hover:underline">Petunjuk Arah →</a>
                        </div>
                    </div>
                    <div class="info-card">
                        <div class="icon-box shrink-0">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#EAB308" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.6 1.27h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 8.91a16 16 0 0 0 6 6l1-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                        </div>
                        <div>
                            <h4 class="text-white font-bold mb-1">Telepon</h4>
                            <p class="text-gray-400 text-sm">0822-8824-0948</p>
                            <p class="text-gray-500 text-xs mt-1">Hubungi untuk booking atau cek ketersediaan</p>
                        </div>
                    </div>
                    <div class="info-card">
                        <div class="icon-box shrink-0">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#EAB308" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                        </div>
                        <div>
                            <h4 class="text-white font-bold mb-1">Jam Buka</h4>
                            <p class="text-gray-400 text-sm">Senin – Sabtu: 08.00 – 20.00</p>
                            <p class="text-gray-400 text-sm">Minggu: 09.00 – 17.00</p>
                        </div>
                    </div>
                </div>
                <div data-aos="fade-left" class="rounded-2xl overflow-hidden border-2 border-[#EAB308]/30 h-80 md:h-full min-h-72">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3946.0!2d115.09!3d-8.58!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zOMKwMzQnNDgiLjAiUyAxMTXCsDA1JzI0LjAiRQ!5e0!3m2!1sid!2sid!4v1"
                        width="100%" height="100%" style="border:0; min-height: 280px;" allowfullscreen loading="lazy">
                    </iframe>
                </div>
            </div>
        </div>
    </section>

    <!-- ═══════════════════════════════════════════ FOOTER ══ -->
    <footer class="py-10 px-6 border-t border-gray-800 bg-dark">
        <div class="max-w-6xl mx-auto flex flex-col md:flex-row justify-between items-center gap-4">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 bg-[#EAB308] rounded-lg flex items-center justify-center">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#000" stroke-width="2.5"><path d="M6 3L6 21M18 3L18 21M6 7L18 7M6 17L18 17"/></svg>
                </div>
                <span class="text-white font-bold" style="font-family:'Playfair Display',serif;">Mr. Brokker</span>
            </div>
            <p class="text-gray-600 text-sm">© 2026 Mr. Brokker Barbershop Bali. Semua Hak Dilindungi.</p>
            <a href="{{ route('register') }}" class="text-sm bg-[#EAB308] text-black px-5 py-2 rounded-lg font-bold hover:bg-yellow-400 transition">
                Reservasi Sekarang
            </a>
        </div>
    </footer>

    <!-- JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/glightbox/3.3.0/js/glightbox.min.js"></script>
    <script>
        AOS.init({ duration: 750, once: true, offset: 80 });
        GLightbox({ selector: '.glightbox' });

        const hamburger = document.getElementById('hamburger');
        const mobileMenu = document.getElementById('mobile-menu');
        hamburger.addEventListener('click', () => {
            hamburger.classList.toggle('open');
            mobileMenu.classList.toggle('hidden');
        });
        mobileMenu.querySelectorAll('a').forEach(a => {
            a.addEventListener('click', () => {
                mobileMenu.classList.add('hidden');
                hamburger.classList.remove('open');
            });
        });
    </script>
</body>
</html>