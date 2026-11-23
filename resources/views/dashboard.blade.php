<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
            <div>
                <h2 class="font-bold text-xl text-gray-800 leading-tight">
                    {{ __('Dashboard') }}
                </h2>
                <p class="text-xs text-gray-500">
                    Selamat datang kembali, <span class="font-semibold text-emerald-700">{{ Auth::user()->name }}</span> 
                    ({{ Auth::user()->isAdmin() ? 'Administrator Kampus' : 'Mahasiswa' }})
                </p>
            </div>
            <div>
                <a href="{{ route('barangs.create') }}" class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-xl shadow-sm transition">
                    + Buat Laporan Barang
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- STATISTIK KARTU KAMPUS -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                
                <!-- KARTU 1: TOTAL HILANG -->
                <div class="bg-white p-5 rounded-2xl border border-gray-100  flex items-center justify-between">
                    <div>
                        <div class="text-xs font-bold uppercase tracking-wider text-rose-500">Barang Hilang</div>
                        <div class="text-2xl font-black text-gray-900 mt-1">{{ $totalHilang }}</div>
                        <div class="text-[11px] text-gray-400 mt-0.5">Sedang dicari</div>
                    </div>
                    <div class="w-12 h-12 bg-rose-50 rounded-xl flex items-center justify-center text-rose-600">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                </div>

                <!-- KARTU 2: TOTAL TEMUAN -->
                <div class="bg-white p-5 rounded-2xl border border-gray-100  flex items-center justify-between">
                    <div>
                        <div class="text-xs font-bold uppercase tracking-wider text-emerald-600">Barang Temuan</div>
                        <div class="text-2xl font-black text-gray-900 mt-1">{{ $totalTemuan }}</div>
                        <div class="text-[11px] text-gray-400 mt-0.5">Menunggu pemilik</div>
                    </div>
                    <div class="w-12 h-12 bg-emerald-50 rounded-xl flex items-center justify-center text-emerald-600">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>

                <!-- KARTU 3: TOTAL SELESAI -->
                <div class="bg-white p-5 rounded-2xl border border-gray-100  flex items-center justify-between">
                    <div>
                        <div class="text-xs font-bold uppercase tracking-wider text-blue-600">Sudah Selesai</div>
                        <div class="text-2xl font-black text-gray-900 mt-1">{{ $totalSelesai }}</div>
                        <div class="text-[11px] text-gray-400 mt-0.5">Kembali ke pemilik</div>
                    </div>
                    <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center text-blue-600">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                </div>

                <!-- KARTU 4: LAPORAN SAYA -->
                <div class="bg-white p-5 rounded-2xl border border-gray-100  flex items-center justify-between">
                    <div>
                        <div class="text-xs font-bold uppercase tracking-wider text-purple-600">Laporan Anda</div>
                        <div class="text-2xl font-black text-gray-900 mt-1">{{ $laporanSayaCount }}</div>
                        <div class="text-[11px] text-gray-400 mt-0.5">Laporan aktif</div>
                    </div>
                    <div class="w-12 h-12 bg-purple-50 rounded-xl flex items-center justify-center text-purple-600">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                </div>

            </div>

            <!-- AKSI CEPAT BANNER -->
            <div class="bg-gradient-to-r from-emerald-800 to-emerald-950 rounded-2xl p-6 sm:p-8 text-white flex flex-col md:flex-row md:items-center md:justify-between gap-6 shadow-sm">
                <div class="space-y-2 max-w-xl">
                    <span class="px-2.5 py-1 bg-emerald-500/30 text-emerald-200 text-xs font-bold rounded-lg uppercase tracking-wider">Layanan Terpadu Kampus</span>
                    <h3 class="text-xl sm:text-2xl font-black">Kehilangan atau Menemukan Barang di Kampus?</h3>
                    <p class="text-emerald-100/80 text-xs sm:text-sm leading-relaxed">
                        Publikasikan barang temuan agar pemilik dapat segera menghubungi Anda, atau laporkan barang Anda yang hilang agar civitas kampus dapat membantu menemukan.
                    </p>
                </div>
                <div class="flex flex-wrap gap-3 shrink-0">
                    <a href="{{ route('barangs.create') }}" class="px-5 py-2.5 bg-emerald-500 hover:bg-emerald-400 text-gray-950 font-bold text-xs sm:text-sm rounded-xl transition shadow-sm">
                        + Buat Laporan Baru
                    </a>
                    <a href="{{ route('beranda') }}" class="px-5 py-2.5 bg-white/10 hover:bg-white/20 text-white font-semibold text-xs sm:text-sm rounded-xl border border-white/20 transition">
                        Jelajahi Katalog
                    </a>
                </div>
            </div>

            <!-- LAPORAN TERBARU TABLE -->
            <div class="bg-white rounded-2xl border border-gray-100  overflow-hidden">
                <div class="p-5 border-b border-gray-100 flex items-center justify-between">
                    <div>
                        <h4 class="font-bold text-gray-900 text-base">Laporan Terbaru di Kampus</h4>
                        <p class="text-xs text-gray-500">Update pelaporan barang hilang dan temuan terbaru.</p>
                    </div>
                    <a href="{{ route('beranda') }}" class="text-xs font-bold text-emerald-700 hover:text-emerald-800">
                        Lihat Semua →
                    </a>
                </div>

                <div class="divide-y divide-gray-100">
                    @forelse($laporanTerbaru as $b)
                        <div class="p-4 sm:px-6 flex items-center justify-between hover:bg-gray-50/50 transition gap-4">
                            <div class="flex items-center gap-3.5">
                                <span class="px-2.5 py-1 text-[11px] font-bold rounded-md shrink-0 {{ $b->jenis == 'hilang' ? 'bg-rose-50 text-rose-700' : 'bg-emerald-50 text-emerald-700' }}">
                                    {{ strtoupper($b->jenis) }}
                                </span>
                                <div>
                                    <a href="{{ route('barangs.show', $b) }}" class="font-bold text-sm text-gray-900 hover:text-emerald-700">
                                        {{ $b->nama_barang }}
                                    </a>
                                    <div class="text-xs text-gray-500 flex items-center gap-2 mt-0.5">
                                        <span>{{ $b->lokasi }}</span>
                                        <span>•</span>
                                        <span>{{ \Carbon\Carbon::parse($b->tanggal)->diffForHumans() }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="shrink-0">
                                <a href="{{ route('barangs.show', $b) }}" class="px-3 py-1.5 bg-gray-100 hover:bg-gray-200 text-gray-800 text-xs font-semibold rounded-lg transition">
                                    Detail
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="p-8 text-center text-xs text-gray-400">
                            Belum ada laporan barang.
                        </div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
