<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-[#F7F8F6]">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $barang->nama_barang }} - Hilang & Temukan UNSIL</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-full flex flex-col font-sans text-gray-800 antialiased bg-[#F7F8F6]">

    <!-- NAVBAR HEADER -->
    <header class="w-full bg-white/90 backdrop-blur-md sticky top-0 z-50 border-b border-gray-200/80">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex justify-between items-center">
            <a href="{{ route('landing') }}" class="flex items-center gap-2.5">
                <div class="w-9 h-9 rounded-xl bg-[#0F5B54] text-white flex items-center justify-center ">
                    <span class="material-symbols-outlined text-[20px]">search_check</span>
                </div>
                <div>
                    <span class="font-extrabold text-base text-gray-900 leading-none block">Hilang & Temukan</span>
                    <span class="text-[9px] text-gray-500 font-bold tracking-wider">UNIVERSITAS SILIWANGI</span>
                </div>
            </a>

            <div class="flex items-center gap-3">
                @auth
                    @if(Auth::user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="text-xs sm:text-sm font-semibold text-[#0F5B54] hover:underline flex items-center gap-1">
                            <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                            <span>Kembali ke Panel Admin</span>
                        </a>
                    @else
                        <a href="{{ route('beranda') }}" class="text-xs sm:text-sm font-semibold text-[#0F5B54] hover:underline flex items-center gap-1">
                            <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                            <span>Kembali ke Katalog</span>
                        </a>
                    @endif
                @else
                    <a href="{{ route('beranda') }}" class="text-xs sm:text-sm font-semibold text-[#0F5B54] hover:underline flex items-center gap-1">
                        <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                        <span>Kembali ke Katalog</span>
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <!-- MAIN DETAIL CONTENT (Sesuai Referensi Gambar 1) -->
    <main class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8 flex-grow w-full space-y-6">

        @if(session('success'))
            <div class="p-4 bg-emerald-50 border border-emerald-200 text-[#0F5B54] rounded-xl flex items-center gap-2 text-sm ">
                <span class="material-symbols-outlined text-[20px]">check_circle</span>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <!-- TOP BAR: BACK LINK & HEADER TITLE -->
        <div class="space-y-3">
            @auth
                @if(Auth::user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-1 text-xs font-semibold text-gray-500 hover:text-[#0F5B54]">
                        <span class="material-symbols-outlined text-[16px]">arrow_back</span>
                        <span>Kembali ke daftar laporan</span>
                    </a>
                @else
                    <a href="{{ route('beranda') }}" class="inline-flex items-center gap-1 text-xs font-semibold text-gray-500 hover:text-[#0F5B54]">
                        <span class="material-symbols-outlined text-[16px]">arrow_back</span>
                        <span>Kembali ke daftar laporan</span>
                    </a>
                @endif
            @else
                <a href="{{ route('beranda') }}" class="inline-flex items-center gap-1 text-xs font-semibold text-gray-500 hover:text-[#0F5B54]">
                    <span class="material-symbols-outlined text-[16px]">arrow_back</span>
                    <span>Kembali ke daftar laporan</span>
                </a>
            @endauth

            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                <div class="flex flex-wrap items-center gap-3">
                    <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-950 tracking-tight">
                        {{ $barang->nama_barang }}
                    </h1>

                    <!-- BADGE JENIS -->
                    @if($barang->jenis == 'hilang')
                        <span class="px-2.5 py-0.5 text-xs font-bold bg-[#FEF3C7] text-[#92400E] rounded-md">
                            Hilang
                        </span>
                    @else
                        <span class="px-2.5 py-0.5 text-xs font-bold bg-[#E6F4F1] text-[#0F5B54] rounded-md">
                            Ditemukan
                        </span>
                    @endif

                    <!-- BADGE STATUS -->
                    @if($barang->status == 'selesai')
                        <span class="px-2.5 py-0.5 text-xs font-bold bg-emerald-100 text-emerald-800 rounded-md">
                            Selesai
                        </span>
                    @elseif($barang->status == 'terverifikasi')
                        <span class="px-2.5 py-0.5 text-xs font-bold bg-gray-100 text-gray-700 rounded-md">
                            Diproses
                        </span>
                    @else
                        <span class="px-2.5 py-0.5 text-xs font-bold bg-[#E6F4F1] text-[#0F5B54] rounded-md">
                            Baru
                        </span>
                    @endif
                </div>

                <div class="text-xs text-gray-400">
                    Dilaporkan {{ $barang->created_at->diffForHumans() }}.
                </div>
            </div>
        </div>

        <!-- 2 KOLOM GRID (Sesuai Referensi Gambar 1) -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
            
            <!-- KOLOM KIRI (SPECS & TIMELINE) -->
            <div class="lg:col-span-8 space-y-6">
                
                <!-- CARD DETAIL BARANG -->
                <div class="bg-white rounded-2xl border border-gray-200/80  p-6 flex flex-col sm:flex-row gap-6">
                    <!-- FOTO ATAU PREVIEW -->
                    <div class="w-full sm:w-56 h-48 bg-[#EBF5F3] rounded-xl flex items-center justify-center shrink-0 overflow-hidden relative border border-gray-100">
                        <img src="{{ $barang->gambar_url }}" alt="{{ $barang->nama_barang }}" class="w-full h-full object-cover">
                        @if(!$barang->hasRealFoto())
                            <span class="absolute bottom-2 text-[10px] text-gray-500 font-medium bg-white/90 px-2 py-0.5 rounded-md ">Foto dari pelapor</span>
                        @endif
                    </div>

                    <!-- SPESIFIKASI INFORMASI (2x2 Grid) -->
                    <div class="flex-1 grid grid-cols-1 sm:grid-cols-2 gap-y-4 gap-x-6 text-xs">
                        <div>
                            <div class="text-gray-400 uppercase font-bold text-[10px] tracking-wider mb-0.5">Kategori</div>
                            <div class="text-gray-900 font-bold text-sm">{{ $barang->kategori }}</div>
                        </div>

                        <div>
                            <div class="text-gray-400 uppercase font-bold text-[10px] tracking-wider mb-0.5">
                                {{ $barang->jenis == 'hilang' ? 'Waktu Hilang' : 'Waktu Ditemukan' }}
                            </div>
                            <div class="text-gray-900 font-bold text-sm">{{ \Carbon\Carbon::parse($barang->tanggal)->translatedFormat('d F Y') }}</div>
                        </div>

                        <div>
                            <div class="text-gray-400 uppercase font-bold text-[10px] tracking-wider mb-0.5">Lokasi Terakhir</div>
                            <div class="text-gray-900 font-bold text-sm">{{ $barang->lokasi }}</div>
                        </div>

                        <div class="sm:col-span-2">
                            <div class="text-gray-400 uppercase font-bold text-[10px] tracking-wider mb-0.5">Ciri-Ciri</div>
                            <div class="text-gray-700 leading-relaxed text-sm bg-gray-50/70 p-3 rounded-xl border border-gray-100">
                                {{ $barang->deskripsi }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- CARD RIWAYAT LAPORAN (TIMELINE STEPPER) (Sesuai Gambar 1) -->
                <div class="bg-white rounded-2xl border border-gray-200/80  p-6 space-y-5">
                    <h3 class="font-extrabold text-base text-gray-900">Riwayat laporan</h3>

                    <div class="space-y-6 relative pl-2">
                        <!-- Step 1: Laporan dikirim -->
                        <div class="flex items-start gap-3.5 relative">
                            <div class="w-6 h-6 rounded-full bg-[#0F5B54] text-white flex items-center justify-center shrink-0 ">
                                <span class="material-symbols-outlined text-[16px]">check</span>
                            </div>
                            <div>
                                <div class="font-bold text-sm text-gray-900">Laporan dikirim mahasiswa</div>
                                <div class="text-xs text-gray-400">{{ $barang->created_at->diffForHumans() }}</div>
                            </div>
                        </div>

                        <!-- Step 2: Menunggu verifikasi admin -->
                        <div class="flex items-start gap-3.5 relative">
                            @if($barang->status == 'menunggu')
                                <div class="w-6 h-6 rounded-full border-2 border-[#0F5B54] bg-white flex items-center justify-center shrink-0">
                                    <div class="w-2 h-2 rounded-full bg-[#0F5B54]"></div>
                                </div>
                                <div>
                                    <div class="font-bold text-sm text-[#0F5B54]">Menunggu verifikasi admin</div>
                                    <div class="text-xs text-[#0F5B54]">Tahap saat ini</div>
                                </div>
                            @else
                                <div class="w-6 h-6 rounded-full bg-[#0F5B54] text-white flex items-center justify-center shrink-0">
                                    <span class="material-symbols-outlined text-[16px]">check</span>
                                </div>
                                <div>
                                    <div class="font-bold text-sm text-gray-900">Laporan diverifikasi admin</div>
                                    <div class="text-xs text-gray-400">Selesai diperiksa</div>
                                </div>
                            @endif
                        </div>

                        <!-- Step 3: Dicocokkan dengan barang temuan -->
                        <div class="flex items-start gap-3.5 relative">
                            @if($barang->status == 'terverifikasi')
                                <div class="w-6 h-6 rounded-full border-2 border-[#0F5B54] bg-white flex items-center justify-center shrink-0">
                                    <div class="w-2 h-2 rounded-full bg-[#0F5B54]"></div>
                                </div>
                                <div>
                                    <div class="font-bold text-sm text-[#0F5B54]">Dicocokkan dengan barang temuan</div>
                                    <div class="text-xs text-[#0F5B54]">Tahap saat ini &bull; Tampil di katalog publik</div>
                                </div>
                            @elseif($barang->status == 'selesai')
                                <div class="w-6 h-6 rounded-full bg-[#0F5B54] text-white flex items-center justify-center shrink-0">
                                    <span class="material-symbols-outlined text-[16px]">check</span>
                                </div>
                                <div>
                                    <div class="font-bold text-sm text-gray-900">Dicocokkan dengan barang temuan</div>
                                    <div class="text-xs text-gray-400">Pencocokan berhasil</div>
                                </div>
                            @else
                                <div class="w-6 h-6 rounded-full border-2 border-gray-300 bg-white flex items-center justify-center shrink-0"></div>
                                <div>
                                    <div class="font-medium text-sm text-gray-400">Dicocokkan dengan barang temuan</div>
                                </div>
                            @endif
                        </div>

                        <!-- Step 4: Barang dikembalikan -->
                        <div class="flex items-start gap-3.5 relative">
                            @if($barang->status == 'selesai')
                                <div class="w-6 h-6 rounded-full bg-emerald-600 text-white flex items-center justify-center shrink-0">
                                    <span class="material-symbols-outlined text-[16px]">check</span>
                                </div>
                                <div>
                                    <div class="font-bold text-sm text-emerald-800">Barang dikembalikan ke pemilik</div>
                                    <div class="text-xs text-emerald-600">Kasus tuntas / barang telah diserahkan</div>
                                </div>
                            @else
                                <div class="w-6 h-6 rounded-full border-2 border-gray-300 bg-white flex items-center justify-center shrink-0"></div>
                                <div>
                                    <div class="font-medium text-sm text-gray-400">Barang dikembalikan ke pemilik</div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

            </div>

            <!-- KOLOM KANAN (PELAPOR & TINDAKAN) -->
            <div class="lg:col-span-4 space-y-6">
                
                <!-- CARD PELAPOR (Sesuai Referensi Gambar 1) -->
                <div class="bg-white rounded-2xl border border-gray-200/80  p-5 space-y-4">
                    <h3 class="font-extrabold text-sm text-gray-900">Pelapor</h3>

                    <div class="flex items-center gap-3">
                        @php
                            $words = explode(' ', $barang->user->name);
                            $initials = strtoupper(substr($words[0], 0, 1) . (isset($words[1]) ? substr($words[1], 0, 1) : ''));
                        @endphp
                        <div class="w-11 h-11 rounded-full bg-[#E6F4F1] text-[#0F5B54] font-bold text-sm flex items-center justify-center shrink-0">
                            {{ $initials }}
                        </div>
                        <div class="truncate">
                            <div class="font-bold text-sm text-gray-900 leading-tight">{{ $barang->user->name }}</div>
                            @if($barang->user->npm)
                                <div class="text-xs text-gray-400">NPM: {{ $barang->user->npm }}</div>
                            @endif
                        </div>
                    </div>

                    <div class="pt-2 border-t border-gray-100 flex items-center gap-2 text-xs text-gray-600">
                        <span class="material-symbols-outlined text-[18px] text-gray-400">call</span>
                        <span class="font-medium">{{ $barang->kontak }}</span>
                    </div>
                </div>

                <!-- CARD TINDAKAN (Sesuai Referensi Gambar 1) -->
                <div class="bg-white rounded-2xl border border-gray-200/80  p-5 space-y-4">
                    <h3 class="font-extrabold text-sm text-gray-900">
                        {{ (Auth::check() && Auth::user()->isAdmin()) ? 'Tindakan admin' : 'Tindakan' }}
                    </h3>

                    <!-- FORM UBAH STATUS (Khusus Pemilik / Admin) -->
                    @auth
                        @if(Auth::id() == $barang->user_id || Auth::user()->isAdmin())
                            <form method="POST" action="{{ route('barangs.status', $barang) }}" class="space-y-3">
                                @csrf
                                @method('PATCH')
                                <div>
                                    <label class="block text-xs font-semibold text-gray-600 mb-1">Ubah status</label>
                                    <select name="status" class="w-full text-xs rounded-xl border border-gray-300 py-2 px-3 bg-white focus:border-[#0F5B54] focus:ring-1 focus:ring-[#0F5B54]">
                                        <option value="menunggu" {{ $barang->status == 'menunggu' ? 'selected' : '' }}>Baru / Menunggu</option>
                                        <option value="terverifikasi" {{ $barang->status == 'terverifikasi' ? 'selected' : '' }}>Diproses / Aktif</option>
                                        <option value="selesai" {{ $barang->status == 'selesai' ? 'selected' : '' }}>Selesai / Dikembalikan</option>
                                    </select>
                                </div>
                                <button type="submit" class="w-full py-2.5 px-4 bg-[#0F5B54] hover:bg-[#0C4A44] text-white font-bold text-xs rounded-xl  transition">
                                    Simpan status
                                </button>
                            </form>
                        @endif
                    @endauth

                    <!-- COCOKKAN DENGAN BARANG LAIN -->
                    <a href="{{ route('beranda', ['q' => $barang->kategori]) }}" 
                       class="w-full block text-center py-2 px-3 border border-[#0F5B54] text-[#0F5B54] hover:bg-[#E6F4F1] font-bold text-xs rounded-xl transition">
                        Cocokkan dengan barang temuan
                    </a>

                    <!-- HUBUNGI VIA WA -->
                    @php
                        $nomorWa = preg_replace('/[^0-9]/', '', $barang->kontak);
                        if (str_starts_with($nomorWa, '0')) $nomorWa = '62' . substr($nomorWa, 1);
                        $pesanWa = "Halo {$barang->user->name}, saya ingin konfirmasi terkait laporan '{$barang->nama_barang}' di Hilang & Temukan UNSIL.";
                        $waUrl = "https://wa.me/{$nomorWa}?text=" . urlencode($pesanWa);
                    @endphp
                    <a href="{{ $waUrl }}" target="_blank"
                       class="w-full flex items-center justify-center gap-1.5 py-2 px-3 border border-gray-300 text-gray-700 hover:bg-gray-50 font-semibold text-xs rounded-xl transition">
                        <span class="material-symbols-outlined text-[16px]">chat</span>
                        <span>Hubungi pelapor</span>
                    </a>

                    <!-- EDIT & HAPUS -->
                    @auth
                        @if(Auth::id() == $barang->user_id || Auth::user()->isAdmin())
                            <div class="pt-3 border-t border-gray-100 flex items-center gap-2">
                                <a href="{{ route('barangs.edit', $barang) }}" class="flex-1 py-1.5 text-center text-xs font-semibold text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition">
                                    Edit
                                </a>
                                <form method="POST" action="{{ route('barangs.destroy', $barang) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus laporan ini?')" class="flex-1">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-full py-1.5 text-center text-xs font-semibold text-rose-600 bg-rose-50 hover:bg-rose-100 rounded-lg transition">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        @endif
                    @endauth
                </div>

            </div>

        </div>

    </main>

</body>
</html>