<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-xl text-gray-800 leading-tight">
                {{ __('Edit Laporan Barang') }}
            </h2>
            <a href="{{ route('barangs.show', $barang) }}" class="text-xs font-semibold text-emerald-700 hover:text-emerald-800">
                ← Kembali ke Detail
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100 p-6 sm:p-8">

                <form method="POST" action="{{ route('barangs.update', $barang) }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- STATUS LAPORAN -->
                    <div>
                        <x-input-label for="status" :value="__('Status Laporan *')" />
                        <select id="status" name="status" required class="block mt-1 w-full border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-lg shadow-sm text-sm">
                            <option value="terverifikasi" {{ old('status', $barang->status) == 'terverifikasi' ? 'selected' : '' }}>Aktif / Terverifikasi</option>
                            <option value="selesai" {{ old('status', $barang->status) == 'selesai' ? 'selected' : '' }}>Selesai (Sudah Ditemukan / Sudah Dikembalikan)</option>
                            <option value="menunggu" {{ old('status', $barang->status) == 'menunggu' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                        </select>
                        <x-input-error :messages="$errors->get('status')" class="mt-2" />
                    </div>

                    <!-- PILIH JENIS LAPORAN (RADIO TOGGLE) -->
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Jenis Laporan *</label>
                        <div class="grid grid-cols-2 gap-4">
                            <label class="relative flex flex-col p-4 border rounded-xl cursor-pointer hover:border-rose-400 has-[:checked]:border-rose-600 has-[:checked]:bg-rose-50/50 transition">
                                <input type="radio" name="jenis" value="hilang" class="sr-only" {{ old('jenis', $barang->jenis) == 'hilang' ? 'checked' : '' }} required>
                                <span class="flex items-center gap-2 font-bold text-rose-700 text-sm sm:text-base">
                                    <span class="w-3 h-3 rounded-full bg-rose-600 inline-block"></span>
                                    Barang Hilang
                                </span>
                            </label>

                            <label class="relative flex flex-col p-4 border rounded-xl cursor-pointer hover:border-emerald-400 has-[:checked]:border-emerald-600 has-[:checked]:bg-emerald-50/50 transition">
                                <input type="radio" name="jenis" value="ditemukan" class="sr-only" {{ old('jenis', $barang->jenis) == 'ditemukan' ? 'checked' : '' }}>
                                <span class="flex items-center gap-2 font-bold text-emerald-700 text-sm sm:text-base">
                                    <span class="w-3 h-3 rounded-full bg-emerald-600 inline-block"></span>
                                    Barang Ditemukan
                                </span>
                            </label>
                        </div>
                        <x-input-error :messages="$errors->get('jenis')" class="mt-2" />
                    </div>

                    <!-- NAMA BARANG -->
                    <div>
                        <x-input-label for="nama_barang" :value="__('Nama Barang *')" />
                        <x-text-input id="nama_barang" class="block mt-1 w-full" type="text" name="nama_barang" :value="old('nama_barang', $barang->nama_barang)" required />
                        <x-input-error :messages="$errors->get('nama_barang')" class="mt-2" />
                    </div>

                    <!-- KATEGORI -->
                    <div>
                        <x-input-label for="kategori" :value="__('Kategori Barang *')" />
                        <select id="kategori" name="kategori" required class="block mt-1 w-full border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-lg shadow-sm text-sm">
                            @foreach($kategoriList as $kat)
                                <option value="{{ $kat }}" {{ old('kategori', $barang->kategori) == $kat ? 'selected' : '' }}>{{ $kat }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('kategori')" class="mt-2" />
                    </div>

                    <!-- DESKRIPSI -->
                    <div>
                        <x-input-label for="deskripsi" :value="__('Deskripsi & Ciri-Ciri Khusus *')" />
                        <textarea id="deskripsi" name="deskripsi" rows="4" required class="block mt-1 w-full border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-lg shadow-sm text-sm">{{ old('deskripsi', $barang->deskripsi) }}</textarea>
                        <x-input-error :messages="$errors->get('deskripsi')" class="mt-2" />
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- LOKASI -->
                        <div>
                            <x-input-label for="lokasi" :value="__('Lokasi *')" />
                            <x-text-input id="lokasi" class="block mt-1 w-full" type="text" name="lokasi" :value="old('lokasi', $barang->lokasi)" required />
                            <x-input-error :messages="$errors->get('lokasi')" class="mt-2" />
                        </div>

                        <!-- TANGGAL -->
                        <div>
                            <x-input-label for="tanggal" :value="__('Tanggal Kejadian *')" />
                            <x-text-input id="tanggal" class="block mt-1 w-full" type="date" name="tanggal" :value="old('tanggal', $barang->tanggal ? $barang->tanggal->format('Y-m-d') : '')" required />
                            <x-input-error :messages="$errors->get('tanggal')" class="mt-2" />
                        </div>
                    </div>

                    <!-- KONTAK -->
                    <div>
                        <x-input-label for="kontak" :value="__('Nomor WhatsApp untuk Kontak / Klaim *')" />
                        <x-text-input id="kontak" class="block mt-1 w-full" type="tel" name="kontak" :value="old('kontak', $barang->kontak)" required />
                        <x-input-error :messages="$errors->get('kontak')" class="mt-2" />
                    </div>

                    <!-- GANTI FOTO BARANG -->
                    <div>
                        <x-input-label for="foto" :value="__('Ganti Foto Barang (Opsional)')" />
                        @if($barang->foto && file_exists(public_path('storage/' . $barang->foto)))
                            <div class="my-2 flex items-center gap-3">
                                <img src="{{ asset('storage/' . $barang->foto) }}" class="h-16 w-16 object-cover rounded-lg border">
                                <span class="text-xs text-gray-500">Foto saat ini</span>
                            </div>
                        @endif
                        <input id="foto" type="file" name="foto" accept="image/*" class="block mt-1 w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 cursor-pointer" />
                        <x-input-error :messages="$errors->get('foto')" class="mt-2" />
                    </div>

                    <div class="pt-4 border-t border-gray-100 flex items-center justify-end gap-3">
                        <a href="{{ route('barangs.show', $barang) }}" class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition">
                            Batal
                        </a>
                        <button type="submit" class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm rounded-lg shadow-sm transition">
                            Simpan Perubahan
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</x-app-layout>
