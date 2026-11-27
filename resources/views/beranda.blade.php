<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-[#F7F8F6]">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Katalog Barang Hilang & Temuan - UNSIL</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-full flex flex-col font-sans text-gray-800 antialiased bg-[#F7F8F6]">

    <!-- NAVBAR HEADER -->
    <header class="w-full bg-[#F7F8F6]/90 backdrop-blur-md sticky top-0 z-50 border-b border-gray-200/60">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex justify-between items-center">
            <a href="{{ route('beranda') }}" class="flex items-center gap-3 group">
                <div class="w-10 h-10 rounded-xl bg-[#0F5B54] text-white flex items-center justify-center ">
                    <span class="material-symbols-outlined text-[24px]">search_check</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="font-extrabold text-lg text-gray-950 tracking-tight">Hilang & Temukan</span>
                    <span class="hidden sm:inline-block text-gray-300">|</span>
                    <span class="hidden sm:inline-block text-xs text-gray-500 font-medium">Universitas Siliwangi</span>
                </div>
            </a>

            <!-- NAV ACTIONS -->
            <div class="flex items-center gap-2 sm:gap-3">
                @auth
                    <a href="{{ route('barangs.my') }}" class="hidden sm:inline-flex items-center text-sm font-semibold text-gray-700 hover:text-[#0F5B54]">
                        Laporan Saya
                    </a>
                    <a href="{{ route('barangs.create') }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-[#0F5B54] hover:bg-[#0C4A44] text-white text-xs sm:text-sm font-bold rounded-xl transition">
                        <span class="material-symbols-outlined text-[18px]">add</span>
                        <span>Buat Laporan</span>
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="inline-flex items-center gap-1 px-3 py-2 bg-rose-50 hover:bg-rose-100 text-rose-700 text-xs sm:text-sm font-bold rounded-xl border border-rose-200 transition">
                            <span class="material-symbols-outlined text-[18px]">logout</span>
                            <span class="hidden sm:inline">Keluar</span>
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="inline-flex items-center px-4 py-2 bg-[#0F5B54] hover:bg-[#0C4A44] text-white text-sm font-bold rounded-xl transition">
                        Masuk
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <!-- HERO SEARCH SECTION -->
    <section class="bg-white border-b border-gray-200 py-8 sm:py-12">
        <div class="max-w-3xl mx-auto px-4 text-left sm:text-center space-y-3">
            <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight">
                Katalog Barang Hilang & Ditemukan
            </h1>
            <p class="text-sm sm:text-base text-gray-600 max-w-xl sm:mx-auto leading-relaxed">
                Temukan barang yang hilang atau bantu kembalikan barang temuan kepada pemiliknya di lingkungan Universitas Siliwangi.
            </p>

            <!-- FORM PENCARIAN -->
            <form method="GET" action="{{ route('beranda') }}" class="pt-3 max-w-2xl sm:mx-auto">
                @if(request('jenis'))
                    <input type="hidden" name="jenis" value="{{ request('jenis') }}">
                @endif
                @if(request('kategori'))
                    <input type="hidden" name="kategori" value="{{ request('kategori') }}">
                @endif
                <div class="relative flex items-center">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama barang, ciri-ciri, atau lokasi (misal: dompet, helm, rektorat)..."
                        class="block w-full pl-10 pr-24 py-3 text-sm sm:text-base border border-gray-300 rounded-xl bg-white  focus:ring-2 focus:ring-emerald-600 focus:border-emerald-600 transition placeholder:text-gray-400">
                    <button type="submit" class="absolute right-1.5 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs sm:text-sm font-semibold rounded-lg  transition">
                        Cari
                    </button>
                </div>
            </form>
        </div>
    </section>

    <!-- MAIN CONTENT & FILTERS -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 flex-grow w-full">

        @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-600" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
            </div>
        @endif

        <!-- FILTER TABS & KATEGORI -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 pb-6 border-b border-gray-200">
            <!-- Jenis Tabs -->
            <div class="flex items-center gap-1.5 p-1 bg-gray-100 rounded-xl w-fit">
                <a href="{{ route('beranda', array_merge(request()->except('jenis', 'page'), ['jenis' => ''])) }}"
                   class="px-4 py-2 rounded-lg text-xs sm:text-sm font-bold transition {{ !request('jenis') ? 'bg-white text-emerald-800 ' : 'text-gray-600 hover:text-gray-900' }}">
                    Semua ({{ \App\Models\Barang::count() }})
                </a>
                <a href="{{ route('beranda', array_merge(request()->except('jenis', 'page'), ['jenis' => 'hilang'])) }}"
                   class="px-4 py-2 rounded-lg text-xs sm:text-sm font-bold transition {{ request('jenis') == 'hilang' ? 'bg-rose-600 text-white ' : 'text-gray-600 hover:text-gray-900' }}">
                    Barang Hilang ({{ \App\Models\Barang::where('jenis', 'hilang')->count() }})
                </a>
                <a href="{{ route('beranda', array_merge(request()->except('jenis', 'page'), ['jenis' => 'ditemukan'])) }}"
                class="px-4 py-2 rounded-lg text-xs sm:text-sm font-bold transition {{ request('jenis') == 'ditemukan' ? 'bg-emerald-600 text-white ' : 'text-gray-600 hover:text-gray-900' }}">
                    Barang Ditemukan ({{ \App\Models\Barang::where('jenis', 'ditemukan')->count() }})
                </a>
            </div>

            <!-- Kategori Dropdown / Badges -->
            <div class="flex items-center gap-2 overflow-x-auto pb-1">
                <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider shrink-0">Kategori: </span>
                <a href="{{ route('beranda', request()->except('kategori', 'page')) }}"
                class="px-3 py-1.5 rounded-lg text-xs font-semibold transition shrink-0 {{ !request('kategori') ? 'bg-gray-900 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                    Semua
                </a>
                @foreach($kategoriList as $kat)
                    <a href="{{ route('beranda', array_merge(request()->except('page'), ['kategori' => $kat])) }}"
                    class="px-3 py-1.5 rounded-lg text-xs font-semibold transition shrink-0 {{ request('kategori') == $kat ? 'bg-emerald-700 text-white' : 'bg-gray-100 text-gray-700 hover:bg-emerald-100' }}">
                        {{ $kat }}
                    </a>
                @endforeach
            </div>
        </div>

        <!-- LISTING BARANG GRID -->
        <div class="mt-8">
            @if($barangs->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($barangs as $barang)
                        <div class="bg-white rounded-2xl border border-gray-200/80 hover:border-emerald-300  hover:shadow-md transition duration-200 flex flex-col overflow-hidden group">
                            
                            <!-- GAMBAR BARANG ATAU ILUSTRASI KATEGORI -->
                            <div class="h-48 w-full bg-gray-50 relative overflow-hidden flex items-center justify-center border-b border-gray-100">
                                <img src="{{ $barang->gambar_url }}" alt="{{ $barang->nama_barang }}"
                                    class="w-full h-full object-cover group-hover:scale-105 transition duration-300">

                                @if(!$barang->hasRealFoto())
                                    <span class="absolute bottom-2 right-2 px-2 py-0.5 bg-white/90  text-[10px] font-semibold text-gray-500 rounded-md  border border-gray-200">
                                        Ilustrasi
                                    </span>
                                @endif

                                <!-- BADGE JENIS -->
                                <div class="absolute top-3 left-3 flex gap-2">
                                    @if($barang->jenis == 'hilang')
                                        <span class="px-2.5 py-0.5 text-xs font-bold bg-[#FEF3C7] text-[#92400E] rounded-md ">
                                            Hilang
                                        </span>
                                    @else
                                        <span class="px-2.5 py-0.5 text-xs font-bold bg-[#E6F4F1] text-[#0F5B54] rounded-md ">
                                            Ditemukan
                                        </span>
                                    @endif
                                </div>

                                <!-- BADGE STATUS -->
                                <div class="absolute top-3 right-3">
                                    @if($barang->status == 'selesai')
                                        <span class="px-2.5 py-1 text-xs font-bold bg-gray-900/80 backdrop-blur-md text-white rounded-lg shadow-sm">
                                            ✓ Selesai
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <!-- CARD BODY -->
                            <div class="p-5 flex-grow flex flex-col justify-between">
                                <div class="space-y-2.5">
                                    <div class="flex items-center justify-between text-xs text-gray-500">
                                        <span class="px-2 py-0.5 bg-gray-100 rounded-md font-semibold text-gray-700">
                                            {{ $barang->kategori }}
                                        </span>
                                        <span>{{ \Carbon\Carbon::parse($barang->tanggal)->translatedFormat('d M Y') }}</span>
                                    </div>

                                    <h3 class="font-bold text-lg text-gray-900 line-clamp-1 group-hover:text-emerald-700 transition">
                                        <a href="{{ route('barangs.show', $barang) }}">
                                            {{ $barang->nama_barang }}
                                        </a>
                                    </h3>

                                    <p class="text-xs sm:text-sm text-gray-600 line-clamp-2 leading-relaxed">
                                        {{ $barang->deskripsi }}
                                    </p>

                                    <!-- LOKASI -->
                                    <div class="flex items-center gap-1.5 text-xs text-gray-500 pt-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        <span class="truncate font-medium">{{ $barang->lokasi }}</span>
                                    </div>
                                </div>

                                <!-- CARD FOOTER -->
                                <div class="mt-5 pt-3 border-t border-gray-100 flex items-center justify-between">
                                    <div class="text-[11px] text-gray-500 truncate">
                                        Pelapor: <span class="font-semibold text-gray-700">{{ $barang->user->name }}</span>
                                    </div>
                                    <a href="{{ route('barangs.show', $barang) }}"
                                    class="inline-flex items-center gap-1 text-xs font-bold text-emerald-700 hover:text-emerald-800 transition">
                                        Detail →
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- PAGINATION -->
                <div class="mt-8">
                    {{ $barangs->links() }}
                </div>
            @else
                <!-- EMPTY STATE -->
                <div class="text-center py-16 bg-white rounded-2xl border border-gray-200 p-8 space-y-4">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-800">Tidak ada barang yang ditemukan</h3>
                    <p class="text-sm text-gray-500 max-w-md mx-auto">
                        Belum ada laporan yang sesuai dengan filter atau kata kunci pencarian Anda saat ini.
                    </p>
                    <div class="pt-2">
                        <a href="{{ route('beranda') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-bold rounded-xl transition">
                            Reset Filter
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </main>

    <!-- FOOTER -->
    <footer class="bg-white border-t border-gray-200 mt-12 py-8 text-center text-xs text-gray-500">
        <div class="max-w-7xl mx-auto px-4 space-y-2">
            <p>Universitas Siliwangi &copy; {{ date('Y') }}. Dibangun untuk memudahkan aktivitas akademik.</p>
        </div>
    </footer>

</body>
</html>
