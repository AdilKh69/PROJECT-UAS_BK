<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <div class="flex items-center gap-2">
                    <span class="px-2 py-0.5 bg-red-600 text-white text-[10px] font-black uppercase rounded tracking-wider">
                        Admin Mode
                    </span>
                    <h2 class="font-extrabold text-xl text-gray-900 leading-tight">
                        Panel Kontrol Administrator Kampus
                    </h2>
                </div>
                <p class="text-xs text-gray-500 mt-1">
                    Kelola verifikasi laporan, pantau serah terima barang, dan awasi aktivitas civitas akademika UNSIL.
                </p>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('barangs.create') }}" class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-xl  transition">
                    + Input Barang (Pos Satpam)
                </a>
                <a href="{{ route('beranda') }}" target="_blank" class="inline-flex items-center gap-1 px-3 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-bold rounded-xl transition">
                    Lihat Web Publik ↗
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            @if(session('success'))
                <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl flex items-center justify-between text-sm ">
                    <div class="flex items-center gap-2">
                        <svg class="h-5 w-5 text-emerald-600 shrink-0" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        <span>{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            <!-- STATISTIK METRIK LENGKAP -->
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3 sm:gap-4">
                
                <!-- 1. Total Semua Laporan -->
                <div class="bg-white p-4 rounded-2xl border border-gray-100 ">
                    <div class="text-[11px] font-bold text-gray-500 uppercase">Total Laporan</div>
                    <div class="text-2xl font-black text-gray-900 mt-1">{{ $stats['totalSemua'] }}</div>
                    <div class="text-[10px] text-gray-400 mt-0.5">Seluruh arsip</div>
                </div>

                <!-- 2. Menunggu Verifikasi (Highlight) -->
                <div class="bg-white p-4 rounded-2xl border {{ $stats['totalMenunggu'] > 0 ? 'border-amber-300 bg-amber-50/40' : 'border-gray-100' }} ">
                    <div class="text-[11px] font-bold text-amber-700 uppercase">Perlu Verifikasi</div>
                    <div class="text-2xl font-black text-amber-700 mt-1">{{ $stats['totalMenunggu'] }}</div>
                    <div class="text-[10px] text-amber-600 mt-0.5">Laporan tertunda</div>
                </div>

                <!-- 3. Barang Hilang Aktif -->
                <div class="bg-white p-4 rounded-2xl border border-gray-100 ">
                    <div class="text-[11px] font-bold text-rose-600 uppercase">Hilang Aktif</div>
                    <div class="text-2xl font-black text-rose-600 mt-1">{{ $stats['totalHilangAktif'] }}</div>
                    <div class="text-[10px] text-gray-400 mt-0.5">Sedang dicari</div>
                </div>

                <!-- 4. Barang Temuan Aktif -->
                <div class="bg-white p-4 rounded-2xl border border-gray-100 ">
                    <div class="text-[11px] font-bold text-emerald-600 uppercase">Temuan Aktif</div>
                    <div class="text-2xl font-black text-emerald-600 mt-1">{{ $stats['totalTemuanAktif'] }}</div>
                    <div class="text-[10px] text-gray-400 mt-0.5">Belum diambil</div>
                </div>

                <!-- 5. Berhasil Dikembalikan -->
                <div class="bg-white p-4 rounded-2xl border border-gray-100 ">
                    <div class="text-[11px] font-bold text-blue-600 uppercase">Tuntas / Kembali</div>
                    <div class="text-2xl font-black text-blue-600 mt-1">{{ $stats['totalSelesai'] }}</div>
                    <div class="text-[10px] text-gray-400 mt-0.5">Kasus selesai</div>
                </div>

                <!-- 6. Mahasiswa Terdaftar -->
                <div class="bg-white p-4 rounded-2xl border border-gray-100 ">
                    <div class="text-[11px] font-bold text-purple-600 uppercase">Mahasiswa</div>
                    <div class="text-2xl font-black text-purple-600 mt-1">{{ $stats['totalMahasiswa'] }}</div>
                    <div class="text-[10px] text-gray-400 mt-0.5">Pengguna aktif</div>
                </div>

            </div>

            <!-- TABEL KELOLA LAPORAN DENGAN FILTER & SEARCH -->
            <div class="bg-white rounded-2xl border border-gray-100  overflow-hidden">
                
                <!-- HEADER FILTER & SEARCH -->
                <div class="p-5 border-b border-gray-100 space-y-4">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                        <div>
                            <h3 class="font-extrabold text-base text-gray-900">Daftar Seluruh Laporan Barang</h3>
                            <p class="text-xs text-gray-500">Filter berdasarkan status, jenis, atau cari nama pelapor dan NPM.</p>
                        </div>

                        <!-- SEARCH BOX -->
                        <form method="GET" action="{{ route('admin.dashboard') }}" class="flex items-center gap-2">
                            @if(request('status'))
                                <input type="hidden" name="status" value="{{ request('status') }}">
                            @endif
                            @if(request('jenis'))
                                <input type="hidden" name="jenis" value="{{ request('jenis') }}">
                            @endif
                            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari barang, pelapor, NPM..."
                                   class="px-3 py-1.5 text-xs rounded-xl border-gray-200 focus:border-emerald-500 focus:ring-emerald-500 w-52 sm:w-64">
                            <button type="submit" class="px-3.5 py-1.5 bg-gray-900 hover:bg-black text-white text-xs font-semibold rounded-xl transition">
                                Cari
                            </button>
                        </form>
                    </div>

                    <!-- FILTER PILLS -->
                    <div class="flex flex-wrap items-center justify-between gap-2 pt-2 border-t border-gray-50 text-xs">
                        <!-- Status Filter -->
                        <div class="flex items-center gap-1.5 overflow-x-auto pb-1">
                            <span class="text-gray-400 font-bold uppercase tracking-wider text-[10px]">Status:</span>
                            <a href="{{ route('admin.dashboard', array_merge(request()->except('status', 'page'), ['status' => ''])) }}"
                               class="px-2.5 py-1 rounded-lg font-bold transition {{ !request('status') ? 'bg-gray-900 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                                Semua ({{ $stats['totalSemua'] }})
                            </a>
                            <a href="{{ route('admin.dashboard', array_merge(request()->except('status', 'page'), ['status' => 'menunggu'])) }}"
                               class="px-2.5 py-1 rounded-lg font-bold transition {{ request('status') == 'menunggu' ? 'bg-amber-600 text-white' : 'bg-amber-50 text-amber-800 hover:bg-amber-100' }}">
                                ⏳ Menunggu ({{ $stats['totalMenunggu'] }})
                            </a>
                            <a href="{{ route('admin.dashboard', array_merge(request()->except('status', 'page'), ['status' => 'terverifikasi'])) }}"
                               class="px-2.5 py-1 rounded-lg font-bold transition {{ request('status') == 'terverifikasi' ? 'bg-emerald-600 text-white' : 'bg-emerald-50 text-emerald-800 hover:bg-emerald-100' }}">
                                ✓ Terverifikasi / Aktif
                            </a>
                            <a href="{{ route('admin.dashboard', array_merge(request()->except('status', 'page'), ['status' => 'selesai'])) }}"
                               class="px-2.5 py-1 rounded-lg font-bold transition {{ request('status') == 'selesai' ? 'bg-blue-600 text-white' : 'bg-blue-50 text-blue-800 hover:bg-blue-100' }}">
                                🎉 Selesai ({{ $stats['totalSelesai'] }})
                            </a>
                        </div>

                        <!-- Jenis Filter -->
                        <div class="flex items-center gap-1.5">
                            <span class="text-gray-400 font-bold uppercase tracking-wider text-[10px]">Jenis:</span>
                            <a href="{{ route('admin.dashboard', array_merge(request()->except('jenis', 'page'), ['jenis' => ''])) }}"
                                class="px-2.5 py-1 rounded-lg font-bold transition {{ !request('jenis') ? 'bg-gray-800 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                                Semua
                            </a>
                            <a href="{{ route('admin.dashboard', array_merge(request()->except('jenis', 'page'), ['jenis' => 'hilang'])) }}"
                                class="px-2.5 py-1 rounded-lg font-bold transition {{ request('jenis') == 'hilang' ? 'bg-rose-600 text-white' : 'bg-rose-50 text-rose-700 hover:bg-rose-100' }}">
                                Hilang
                            </a>
                            <a href="{{ route('admin.dashboard', array_merge(request()->except('jenis', 'page'), ['jenis' => 'ditemukan'])) }}"
                                class="px-2.5 py-1 rounded-lg font-bold transition {{ request('jenis') == 'ditemukan' ? 'bg-emerald-600 text-white' : 'bg-emerald-50 text-emerald-700 hover:bg-emerald-100' }}">
                                Temuan
                            </a>
                        </div>
                    </div>
                </div>

                <!-- TABEL DATA -->
                @if($barangs->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse text-xs">
                            <thead>
                                <tr class="bg-gray-50/80 border-b border-gray-100 font-bold text-gray-500 uppercase tracking-wider text-[11px]">
                                    <th class="py-3 px-4">Barang</th>
                                    <th class="py-3 px-3">Jenis</th>
                                    <th class="py-3 px-3">Pelapor (Mahasiswa)</th>
                                    <th class="py-3 px-3">Lokasi & Tanggal</th>
                                    <th class="py-3 px-3">Status</th>
                                    <th class="py-3 px-4 text-right">Aksi Manajemen</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($barangs as $b)
                                    <tr class="hover:bg-gray-50/60 transition">
                                        
                                        <!-- BARANG -->
                                        <td class="py-3.5 px-4">
                                            <div class="flex items-center gap-3">
                                                <img src="{{ $b->gambar_url }}" alt="{{ $b->nama_barang }}" class="h-11 w-11 object-cover rounded-xl border border-gray-200 bg-gray-50 shrink-0">
                                                <div>
                                                    <a href="{{ route('barangs.show', $b) }}" target="_blank" class="font-bold text-gray-900 hover:text-emerald-700 block text-sm">
                                                        {{ $b->nama_barang }}
                                                    </a>
                                                    <span class="text-gray-400">Kat: {{ $b->kategori }} &bull; ID: #{{ $b->id }}</span>
                                                </div>
                                            </div>
                                        </td>

                                        <!-- JENIS -->
                                        <td class="py-3.5 px-3 whitespace-nowrap">
                                            @if($b->jenis == 'hilang')
                                                <span class="px-2.5 py-1 text-xs font-bold bg-rose-50 text-rose-700 rounded-md">
                                                    🔴 Hilang
                                                </span>
                                            @else
                                                <span class="px-2.5 py-1 text-xs font-bold bg-emerald-50 text-emerald-700 rounded-md">
                                                    🟢 Temuan
                                                </span>
                                            @endif
                                        </td>

                                        <!-- PELAPOR -->
                                        <td class="py-3.5 px-3 text-xs text-gray-600">
                                            <div class="font-bold text-gray-900">{{ $b->user->name }}</div>
                                            <div class="text-[11px] text-gray-400">{{ $b->user->email }} ({{ $b->user->npm ?? 'Mhs' }})</div>
                                        </td>

                                        <!-- LOKASI & TANGGAL -->
                                        <td class="py-3.5 px-3 text-xs text-gray-600">
                                            <div class="font-medium text-gray-900 truncate max-w-[150px]">{{ $b->lokasi }}</div>
                                            <div class="text-gray-400">{{ \Carbon\Carbon::parse($b->tanggal)->translatedFormat('d M Y') }}</div>
                                        </td>

                                        <!-- STATUS -->
                                        <td class="py-3.5 px-3 whitespace-nowrap">
                                            @if($b->status == 'selesai')
                                                <span class="px-2.5 py-1 text-xs font-bold bg-gray-100 text-gray-700 rounded-full">
                                                    ✓ Selesai
                                                </span>
                                            @elseif($b->status == 'terverifikasi')
                                                <span class="px-2.5 py-1 text-xs font-bold bg-emerald-100 text-emerald-800 rounded-full">
                                                    ✓ Aktif
                                                </span>
                                            @else
                                                <span class="px-2.5 py-1 text-xs font-bold bg-amber-100 text-amber-800 rounded-full animate-pulse">
                                                    ⏳ Menunggu
                                                </span>
                                            @endif
                                        </td>

                                        <!-- AKSI MANAJEMEN ADMIN -->
                                        <td class="py-3.5 px-4 text-right whitespace-nowrap">
                                            <div class="flex items-center justify-end gap-1.5">
                                                
                                                <!-- Verifikasi Cepat -->
                                                @if($b->status == 'menunggu')
                                                    <form method="POST" action="{{ route('admin.barangs.verify', $b) }}">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="px-2.5 py-1 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-xs font-bold transition shadow-2xs" title="Verifikasi Laporan">
                                                            ✓ Setujui
                                                        </button>
                                                    </form>
                                                @endif

                                                <!-- Selesaikan Kasus -->
                                                @if($b->status != 'selesai')
                                                    <form method="POST" action="{{ route('admin.barangs.complete', $b) }}">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="px-2.5 py-1 bg-blue-50 hover:bg-blue-100 text-blue-700 rounded-lg text-xs font-bold transition border border-blue-200" title="Tandai Selesai / Klaim">
                                                            Selesai
                                                        </button>
                                                    </form>
                                                @endif

                                                <!-- Chat WhatsApp Mahasiswa -->
                                                @php
                                                    $no = preg_replace('/[^0-9]/', '', $b->kontak);
                                                    if(str_starts_with($no, '0')) $no = '62' . substr($no, 1);
                                                @endphp
                                                <a href="https://wa.me/{{ $no }}" target="_blank"
                                                   class="p-1.5 bg-green-50 hover:bg-green-100 text-green-700 rounded-lg transition border border-green-200" title="Hubungi Mahasiswa via WA">
                                                    WA
                                                </a>

                                                <a href="{{ route('barangs.edit', $b) }}" class="p-1.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition" title="Edit">
                                                    ✏️
                                                </a>

                                                <form method="POST" action="{{ route('admin.barangs.destroy', $b) }}" onsubmit="return confirm('Hapus permanen laporan ini oleh admin?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="p-1.5 bg-rose-50 hover:bg-rose-100 text-rose-600 rounded-lg transition border border-rose-200" title="Hapus">
                                                        🗑️
                                                    </button>
                                                </form>

                                            </div>
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- PAGINASI -->
                    <div class="p-4 border-t border-gray-100">
                        {{ $barangs->links() }}
                    </div>
                @else
                    <div class="p-12 text-center text-gray-500">
                        Tidak ada laporan yang sesuai dengan filter pencarian.
                    </div>
                @endif

            </div>

            <!-- TABEL MAHASISWA TERDAFTAR -->
            <div class="bg-white rounded-2xl border border-gray-100  overflow-hidden">
                <div class="p-5 border-b border-gray-100 flex items-center justify-between">
                    <div>
                        <h3 class="font-extrabold text-base text-gray-900">Civitas Mahasiswa Terdaftar Terbaru</h3>
                        <p class="text-xs text-gray-500">Mahasiswa yang telah memiliki akun di sistem Hilang & Temukan.</p>
                    </div>
                    <span class="text-xs font-bold text-gray-500 bg-gray-100 px-3 py-1 rounded-full">
                        Total {{ $stats['totalMahasiswa'] }} Mahasiswa
                    </span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-xs">
                        <thead>
                            <tr class="bg-gray-50/80 border-b border-gray-100 font-bold text-gray-500 uppercase tracking-wider text-[11px]">
                                <th class="py-3 px-4">Nama Mahasiswa</th>
                                <th class="py-3 px-3">NPM</th>
                                <th class="py-3 px-3">Email Kampus</th>
                                <th class="py-3 px-3">No. WhatsApp</th>
                                <th class="py-3 px-3 text-center">Jumlah Laporan</th>
                                <th class="py-3 px-4 text-right">Terdaftar</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($mahasiswas as $m)
                                <tr class="hover:bg-gray-50/60 transition">
                                    <td class="py-3 px-4 font-bold text-gray-900">{{ $m->name }}</td>
                                    <td class="py-3 px-3 font-mono text-gray-700">{{ $m->npm ?? '-' }}</td>
                                    <td class="py-3 px-3 text-gray-600">{{ $m->email }}</td>
                                    <td class="py-3 px-3 text-gray-600">{{ $m->no_wa ?? '-' }}</td>
                                    <td class="py-3 px-3 text-center font-bold text-emerald-700">{{ $m->barangs_count }} laporan</td>
                                    <td class="py-3 px-4 text-right text-gray-400">{{ $m->created_at->diffForHumans() }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>