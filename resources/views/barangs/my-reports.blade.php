<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="font-bold text-xl text-gray-800 leading-tight">
                    {{ Auth::user()->isAdmin() ? __('Kelola Semua Laporan (Mode Admin)') : __('Riwayat Laporan Saya') }}
                </h2>
                <p class="text-xs text-gray-500 mt-1">
                    {{ Auth::user()->isAdmin() ? 'Pantau, verifikasi, atau hapus seluruh laporan dari civitas akademika.' : 'Daftar semua laporan barang hilang & temuan yang pernah Anda buat.' }}
                </p>
            </div>
            <a href="{{ route('barangs.create') }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs sm:text-sm font-bold rounded-xl shadow-sm transition">
                + Buat Laporan Baru
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl flex items-center justify-between">
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100">
                @if($barangs->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse text-sm">
                            <thead>
                                <tr class="bg-gray-50/80 border-b border-gray-100 text-xs font-bold text-gray-500 uppercase tracking-wider">
                                    <th class="py-3.5 px-4">Barang</th>
                                    <th class="py-3.5 px-4">Jenis</th>
                                    <th class="py-3.5 px-4">Kategori</th>
                                    <th class="py-3.5 px-4">Lokasi & Tanggal</th>
                                    @if(Auth::user()->isAdmin())
                                        <th class="py-3.5 px-4">Pelapor</th>
                                    @endif
                                    <th class="py-3.5 px-4">Status</th>
                                    <th class="py-3.5 px-4 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($barangs as $b)
                                    <tr class="hover:bg-gray-50/50 transition">
                                        <td class="py-4 px-4">
                                            <div class="flex items-center gap-3">
                                                <img src="{{ $b->gambar_url }}" alt="{{ $b->nama_barang }}" class="h-10 w-10 object-cover rounded-lg border border-gray-200 bg-gray-50 shrink-0">
                                                <div>
                                                    <a href="{{ route('barangs.show', $b) }}" class="font-bold text-gray-900 hover:text-emerald-700 block">
                                                        {{ $b->nama_barang }}
                                                    </a>
                                                    <span class="text-xs text-gray-400">ID: #{{ $b->id }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-4 px-4 whitespace-nowrap">
                                            @if($b->jenis == 'hilang')
                                                <span class="px-2.5 py-1 text-xs font-bold bg-rose-50 text-rose-700 rounded-md">Hilang</span>
                                            @else
                                                <span class="px-2.5 py-1 text-xs font-bold bg-emerald-50 text-emerald-700 rounded-md">Temuan</span>
                                            @endif
                                        </td>
                                        <td class="py-4 px-4 whitespace-nowrap text-xs text-gray-600">
                                            {{ $b->kategori }}
                                        </td>
                                        <td class="py-4 px-4 text-xs text-gray-600">
                                            <div class="font-medium text-gray-800">{{ $b->lokasi }}</div>
                                            <div class="text-gray-400">{{ \Carbon\Carbon::parse($b->tanggal)->translatedFormat('d M Y') }}</div>
                                        </td>
                                        @if(Auth::user()->isAdmin())
                                            <td class="py-4 px-4 text-xs text-gray-600">
                                                <div class="font-semibold text-gray-900">{{ $b->user->name }}</div>
                                                <div class="text-gray-400">{{ $b->user->email }} ({{ $b->kontak }})</div>
                                            </td>
                                        @endif
                                        <td class="py-4 px-4 whitespace-nowrap">
                                            @if($b->status == 'selesai')
                                                <span class="px-2.5 py-1 text-xs font-bold bg-gray-100 text-gray-700 rounded-full">✓ Selesai</span>
                                            @elseif($b->status == 'terverifikasi')
                                                <span class="px-2.5 py-1 text-xs font-bold bg-emerald-100 text-emerald-800 rounded-full">Aktif</span>
                                            @else
                                                <span class="px-2.5 py-1 text-xs font-bold bg-amber-100 text-amber-800 rounded-full">Menunggu</span>
                                            @endif
                                        </td>
                                        <td class="py-4 px-4 whitespace-nowrap text-right">
                                            <div class="flex items-center justify-end gap-2">
                                                <a href="{{ route('barangs.show', $b) }}" class="p-1.5 text-gray-500 hover:text-emerald-700 rounded-lg hover:bg-gray-100" title="Lihat">
                                                    Lihat
                                                </a>

                                                <a href="{{ route('barangs.edit', $b) }}" class="p-1.5 text-gray-500 hover:text-blue-700 rounded-lg hover:bg-gray-100" title="Edit">
                                                    Edit
                                                </a>

                                                <form method="POST" action="{{ route('barangs.destroy', $b) }}" onsubmit="return confirm('Hapus laporan ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="p-1.5 text-rose-500 hover:text-rose-700 rounded-lg hover:bg-rose-50" title="Hapus">
                                                        Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="p-4 border-t border-gray-100">
                        {{ $barangs->links() }}
                    </div>
                @else
                    <div class="text-center py-16 px-4 space-y-4">
                        <div class="w-16 h-16 bg-emerald-50 text-emerald-600 rounded-full flex items-center justify-center mx-auto">
                            <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-800">Belum Ada Laporan</h3>
                        <p class="text-sm text-gray-500 max-w-sm mx-auto">
                            Anda belum pernah membuat laporan kehilangan atau temuan barang.
                        </p>
                        <div class="pt-2">
                            <a href="{{ route('barangs.create') }}" class="inline-flex items-center px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-xl shadow-sm transition">
                                + Buat Laporan Sekarang
                            </a>
                        </div>
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
