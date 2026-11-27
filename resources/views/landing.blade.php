<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Hilang & Temukan - Universitas Siliwangi</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#F7F8F6] text-gray-800 antialiased min-h-screen flex flex-col font-sans">

    <!-- NAVBAR HEADER -->
    <header class="w-full bg-white/90 backdrop-blur-md sticky top-0 z-50 border-b border-gray-100 ">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex justify-between items-center">
            
            <!-- BRAND LOGO -->
            <a href="{{ route('landing') }}" class="flex items-center gap-2.5 group">
                <div class="bg-emerald-600 group-hover:bg-emerald-700 text-white p-2 rounded-xl  transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <div>
                    <span class="font-black text-lg text-emerald-900 leading-none block">Hilang & Temukan</span>
                    <span class="text-[10px] text-emerald-700 font-bold tracking-wider hidden sm:block">UNIVERSITAS SILIWANGI</span>
                </div>
            </a>

            <!-- NAV LINKS -->
            <nav class="hidden md:flex items-center gap-6 text-sm font-semibold text-gray-600">
                <a href="#katalog" class="hover:text-emerald-700 transition">Laporan Terbaru</a>
                <a href="{{ route('beranda') }}" class="hover:text-emerald-700 transition">Katalog Lengkap</a>
                <a href="#cara-kerja" class="hover:text-emerald-700 transition">Alur Pelaporan</a>
            </nav>

            <!-- AUTH BUTTONS -->
            <div class="flex items-center gap-2.5">
                @auth
                    <a href="{{ route('beranda') }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs sm:text-sm font-bold rounded-xl shadow-sm transition">
                        Katalog <span class="hidden sm:inline">& Laporan</span> ({{ Auth::user()->name }})
                    </a>
                @else
                    <a href="{{ route('login') }}" class="inline-flex items-center px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs sm:text-sm font-bold rounded-xl shadow-sm transition">
                        Masuk
                    </a>
                @endauth
            </div>

        </div>
    </header>

    <main class="flex-grow">

        <!-- HERO SECTION (User-Centric Action Portal) -->
        <section class="relative bg-gradient-to-b from-emerald-50/50 via-[#F7F8F6] to-[#F7F8F6] pt-12 pb-16 sm:pt-16 sm:pb-24 border-b border-gray-100 overflow-hidden">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-6">

                <h1 class="text-3xl sm:text-5xl lg:text-6xl font-black text-gray-950 tracking-tight leading-tight max-w-4xl mx-auto">
                    Kehilangan atau Menemukan <br class="hidden sm:inline">
                    Barang di Lingkungan <span class="text-emerald-600">UNSIL</span>?
                </h1>

                <p class="text-sm sm:text-base text-gray-600 max-w-2xl mx-auto leading-relaxed">
                    Jangan panik atau bingung mencari ke mana. Laporkan barang hilangmu atau umumkan barang yang kamu temukan agar cepat kembali ke pemilik aslinya.
                </p>

                <!-- 2 KARTU AKSI UTAMA USER (HILANG VS DITEMUKAN) -->
                <div class="pt-6 max-w-4xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-5 text-left">
                    
                    <!-- KARTU 1: SAYA KEHILANGAN BARANG -->
                    <div class="group relative bg-white p-6 sm:p-7 rounded-3xl border-2 border-rose-100 hover:border-rose-400 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col justify-between">
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <div class="  bg-rose-50 text-rose-600 rounded-2xl flex items-center justify-center p-3 group-hover:scale-110 transition duration-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                    </svg>
                                </div>
                                <span class="px-2.5 py-1 bg-rose-50 text-rose-700 text-[11px] font-extrabold uppercase rounded-lg tracking-wider">
                                    Kehilangan
                                </span>
                            </div>

                            <div>
                                <h3 class="text-xl font-extrabold text-gray-900 group-hover:text-rose-600 transition">
                                    Saya Kehilangan Barang
                                </h3>
                                <p class="text-xs sm:text-sm text-gray-600 mt-2 leading-relaxed">
                                    Barang berhargamu tertinggal di kelas, lab, parkiran, atau kantin? Buat laporan agar warga kampus dan satpam dapat membantu mengidentifikasi.
                                </p>
                            </div>
                        </div>

                        <div class="pt-6 mt-4 border-t border-rose-50 flex items-center justify-between">
                            <a href="{{ route('barangs.create', ['jenis' => 'hilang']) }}"
                               class="w-full inline-flex items-center justify-center gap-2 px-5 py-3 bg-rose-600 hover:bg-rose-700 text-white font-bold text-sm rounded-xl shadow-md transition">
                                <span>Laporkan Barang Hilang</span>
                                <span class="group-hover:translate-x-1 transition-transform">→</span>
                            </a>
                        </div>
                    </div>

                    <!-- KARTU 2: SAYA MENEMUKAN BARANG -->
                    <div class="group relative bg-white p-6 sm:p-7 rounded-3xl border-2 border-emerald-100 hover:border-emerald-500 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col justify-between">
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <div class="  bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center p-3 group-hover:scale-110 transition duration-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <span class="px-2.5 py-1 bg-emerald-50 text-emerald-700 text-[11px] font-extrabold uppercase rounded-lg tracking-wider">
                                    Temuan
                                </span>
                            </div>

                            <div>
                                <h3 class="text-xl font-extrabold text-gray-900 group-hover:text-emerald-700 transition">
                                    Saya Menemukan Barang
                                </h3>
                                <p class="text-xs sm:text-sm text-gray-600 mt-2 leading-relaxed">
                                    Menemukan gawai, kunci, dompet, berkas, atau KTM milik orang lain? Unggah fotonya di sini agar pemilik yang sah bisa segera menghubungi Anda.
                                </p>
                            </div>
                        </div>

                        <div class="pt-6 mt-4 border-t border-emerald-50 flex items-center justify-between">
                            <a href="{{ route('barangs.create', ['jenis' => 'ditemukan']) }}"
                               class="w-full inline-flex items-center justify-center gap-2 px-5 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm rounded-xl shadow-md transition">
                                <span>Laporkan Barang Temuan</span>
                                <span class="group-hover:translate-x-1 transition-transform">→</span>
                            </a>
                        </div>
                    </div>

                </div>

                <!-- LIVE QUICK SEARCH BAR -->
                <div class="pt-8 max-w-2xl mx-auto">
                    <form method="GET" action="{{ route('beranda') }}" class="relative flex items-center">
                        <div class="absolute left-4 text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input type="text" name="q" placeholder="Cari langsung: Kunci motor, dompet kulit, KTM, laptop..."
                               class="w-full pl-12 pr-28 py-3.5 bg-white border border-gray-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 rounded-2xl shadow-sm text-sm text-gray-800 placeholder-gray-400 transition">
                        <button type="submit" class="absolute right-2 px-5 py-2 bg-emerald-700 hover:bg-emerald-800 text-white font-semibold text-xs sm:text-sm rounded-xl transition">
                            Cari
                        </button>
                    </form>

                    <!-- QUICK FILTER BADGES -->
                    <div class="mt-3 flex flex-wrap items-center justify-center gap-2 text-xs text-gray-500">
                        <span class="font-medium">Populer:</span>
                        <a href="{{ route('beranda', ['kategori' => 'Kunci']) }}" class="px-2.5 py-1 bg-white hover:bg-gray-100 rounded-lg border border-gray-200 text-gray-700 transition">Kunci</a>
                        <a href="{{ route('beranda', ['kategori' => 'Dompet / Kartu']) }}" class="px-2.5 py-1 bg-white hover:bg-gray-100 rounded-lg border border-gray-200 text-gray-700 transition">Dompet & KTM</a>
                        <a href="{{ route('beranda', ['kategori' => 'Elektronik']) }}" class="px-2.5 py-1 bg-white hover:bg-gray-100 rounded-lg border border-gray-200 text-gray-700 transition">Elektronik</a>
                        <a href="{{ route('beranda', ['kategori' => 'Dokumen / Berkas']) }}" class="px-2.5 py-1 bg-white hover:bg-gray-100 rounded-lg border border-gray-200 text-gray-700 transition">Dokumen</a>
                    </div>
                </div>

            </div>
        </section>

        <!-- STATISTIK KAMPUS SECTION -->
        <section class="bg-white py-10 border-b border-gray-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 text-center divide-y sm:divide-y-0 sm:divide-x divide-gray-100">
                    <div class="pt-4 sm:pt-0">
                        <div class="text-3xl sm:text-4xl font-black text-rose-600">{{ $totalHilang }}</div>
                        <div class="text-xs sm:text-sm font-bold text-gray-700 uppercase tracking-wider mt-1">Laporan Barang Hilang</div>
                        <div class="text-xs text-gray-400 mt-0.5">Sedang dicari oleh pemilik</div>
                    </div>
                    <div class="pt-4 sm:pt-0">
                        <div class="text-3xl sm:text-4xl font-black text-emerald-600">{{ $totalTemuan }}</div>
                        <div class="text-xs sm:text-sm font-bold text-gray-700 uppercase tracking-wider mt-1">Laporan Barang Temuan</div>
                        <div class="text-xs text-gray-400 mt-0.5">Menunggu diambil pemilik yang sah</div>
                    </div>
                    <div class="pt-4 sm:pt-0">
                        <div class="text-3xl sm:text-4xl font-black text-blue-600">{{ $totalSelesai }}</div>
                        <div class="text-xs sm:text-sm font-bold text-gray-700 uppercase tracking-wider mt-1">Berhasil Dikembalikan</div>
                        <div class="text-xs text-gray-400 mt-0.5">Tuntas berkat bantuan warga UNSIL</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- SHOWCASE LAPORAN TERBARU (LIVE FEED) -->
        <section id="katalog" class="py-14 sm:py-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-8 gap-4">
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-emerald-700">Laporan Terkini</span>
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900 mt-1">Barang Terbaru di Kampus UNSIL</h2>
                    <p class="text-xs sm:text-sm text-gray-500 mt-1">Lihat barang-barang yang baru saja dilaporkan hilang atau ditemukan.</p>
                </div>
                <a href="{{ route('beranda') }}" class="inline-flex items-center gap-1.5 text-xs sm:text-sm font-bold text-emerald-700 hover:text-emerald-800 transition">
                    Lihat Semua di Katalog Lengkap →
                </a>
            </div>

            @if($barangsTerbaru->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($barangsTerbaru as $b)
                        <div class="bg-white rounded-2xl border border-gray-200/80 hover:border-emerald-300  hover:shadow-md transition duration-200 flex flex-col overflow-hidden group">
                            
                            <!-- GAMBAR BARANG (Foto Asli atau Placeholder Line Art Simpel) -->
                            <div class="h-44 w-full bg-[#EBF5F3] relative overflow-hidden flex items-center justify-center border-b border-gray-100">
                                <img src="{{ $b->gambar_url }}" alt="{{ $b->nama_barang }}"
                                    class="w-full h-full object-cover group-hover:scale-105 transition duration-300">

                                <!-- BADGE JENIS -->
                                <div class="absolute top-3 left-3">
                                    @if($b->jenis == 'hilang')
                                        <span class="px-2.5 py-0.5 text-[11px] font-bold bg-[#FEF3C7] text-[#92400E] rounded-md ">
                                            Hilang
                                        </span>
                                    @else
                                        <span class="px-2.5 py-0.5 text-[11px] font-bold bg-[#E6F4F1] text-[#0F5B54] rounded-md ">
                                            Ditemukan
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <!-- CARD CONTENT -->
                            <div class="p-5 flex-grow flex flex-col justify-between">
                                <div class="space-y-2">
                                    <div class="flex items-center justify-between text-xs text-gray-500">
                                        <span class="px-2 py-0.5 bg-gray-100 rounded text-gray-700 font-semibold">{{ $b->kategori }}</span>
                                        <span>{{ \Carbon\Carbon::parse($b->tanggal)->translatedFormat('d M Y') }}</span>
                                    </div>

                                    <h3 class="font-bold text-base text-gray-900 group-hover:text-emerald-700 transition line-clamp-1">
                                        <a href="{{ route('barangs.show', $b) }}">
                                            {{ $b->nama_barang }}
                                        </a>
                                    </h3>

                                    <p class="text-xs text-gray-600 line-clamp-2 leading-relaxed">
                                        {{ $b->deskripsi }}
                                    </p>

                                    <div class="flex items-center gap-1.5 text-xs text-gray-500 pt-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        <span class="truncate">{{ $b->lokasi }}</span>
                                    </div>
                                </div>

                                <div class="mt-4 pt-3 border-t border-gray-100 flex items-center justify-between text-xs">
                                    <span class="text-gray-400">Pelapor: <strong class="text-gray-700">{{ $b->user->name }}</strong></span>
                                    <a href="{{ route('barangs.show', $b) }}" class="font-bold text-emerald-700 hover:text-emerald-800">
                                        Detail →
                                    </a>
                                </div>
                            </div>

                        </div>
                    @endforeach
                </div>

                <div class="mt-10 text-center">
                    <a href="{{ route('beranda') }}"
                    class="inline-flex items-center gap-2 px-6 py-3 bg-white hover:bg-gray-50 text-emerald-800 font-bold text-sm rounded-xl border border-emerald-200  hover:shadow-sm transition">
                        <span>Buka Katalog Lengkap</span>
                        <span>→</span>
                    </a>
                </div>
            @else
                <div class="p-12 text-center bg-white rounded-2xl border border-gray-200 text-gray-500">
                    Belum ada laporan aktif saat ini.
                </div>
            @endif
        </section>

        <!-- CARA KERJA / ALUR PELAPORAN -->
        <section id="cara-kerja" class="py-14 sm:py-20 bg-gradient-to-b from-gray-50 to-emerald-50/40 border-t border-gray-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-12">
                
                <div>
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900 mt-1">Bagaimana Alur Pelaporan Berjalan?</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-left">
                    
                    <!-- LANGKAH 1 -->
                    <div class="bg-white p-6 rounded-2xl border border-gray-200/80  space-y-3">
                        <div class="w-10 h-10 bg-emerald-100 text-emerald-800 font-black rounded-xl flex items-center justify-center text-lg">
                            1
                        </div>
                        <h4 class="font-extrabold text-base text-gray-900">Buat Laporan Singkat</h4>
                        <p class="text-xs sm:text-sm text-gray-600 leading-relaxed">
                            Pilih jenis laporan (*Hilang* atau *Ditemukan*), tulis ciri khas barang, lokasi kejadian di kampus UNSIL, dan sertakan foto jika ada.
                        </p>
                    </div>

                    <!-- LANGKAH 2 -->
                    <div class="bg-white p-6 rounded-2xl border border-gray-200/80  space-y-3">
                        <div class="w-10 h-10 bg-emerald-100 text-emerald-800 font-black rounded-xl flex items-center justify-center text-lg">
                            2
                        </div>
                        <h4 class="font-extrabold text-base text-gray-900">Muncul di Katalog Publik</h4>
                        <p class="text-xs sm:text-sm text-gray-600 leading-relaxed">
                            Laporan langsung tampil di katalog publik sehingga seluruh civitas kampus, satpam, dan rekan mahasiswa bisa mencocokkan barang.
                        </p>
                    </div>

                    <!-- LANGKAH 3 -->
                    <div class="bg-white p-6 rounded-2xl border border-gray-200/80  space-y-3">
                        <div class="w-10 h-10 bg-emerald-100 text-emerald-800 font-black rounded-xl flex items-center justify-center text-lg">
                            3
                        </div>
                        <h4 class="font-extrabold text-base text-gray-900">Terhubung via WhatsApp</h4>
                        <p class="text-xs sm:text-sm text-gray-600 leading-relaxed">
                            Pemilik atau penemu bisa langsung mengklik tombol kontak WhatsApp untuk verifikasi kepemilikan dan serah terima secara aman.
                        </p>
                    </div>

                </div>

                <!-- CTA BOTTOM -->
                <div class="pt-4">
                    <a href="{{ route('barangs.create') }}" class="inline-flex items-center gap-2 px-6 py-3.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm rounded-2xl shadow-lg hover:shadow-xl transition">
                    Mulai Buat Laporan Sekarang
                    </a>
                </div>

            </div>
        </section>

    </main>

    <!-- FOOTER -->
    <footer class="w-full bg-white border-t border-gray-200 py-10 text-xs text-gray-500">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row items-center justify-between gap-4 text-center md:text-left">
            <div>
                <div class="font-extrabold text-sm text-gray-900">Hilang & Temukan &bull; Universitas Siliwangi</div>
                <div class="text-gray-400 mt-1">Platform Pelaporan Kampus &copy; {{ date('Y') }}. Seluruh hak cipta dilindungi.</div>
            </div>

            <div class="flex items-center gap-6 font-medium text-gray-600">
                <a href="{{ route('beranda') }}" class="hover:text-emerald-700">Katalog Barang</a>
                <a href="{{ route('login') }}" class="hover:text-emerald-700">Masuk Akun</a>
            </div>
        </div>
    </footer>

</body>
</html>