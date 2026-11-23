<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-xl text-gray-800 leading-tight">
                {{ __('Buat Laporan Barang Baru') }}
            </h2>
            <a href="{{ route('beranda') }}" class="text-xs font-semibold text-emerald-700 hover:text-emerald-800">
                ← Kembali ke Katalog
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100 p-6 sm:p-8">

                <form method="POST" action="{{ route('barangs.store') }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <!-- PILIH JENIS LAPORAN (RADIO TOGGLE) -->
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Jenis Laporan *</label>
                        <div class="grid grid-cols-2 gap-4">
                            <label class="relative flex flex-col p-4 border rounded-xl cursor-pointer hover:border-rose-400 has-[:checked]:border-rose-600 has-[:checked]:bg-rose-50/50 transition">
                                <input type="radio" name="jenis" value="hilang" class="sr-only" {{ old('jenis', request('jenis', 'hilang')) == 'hilang' ? 'checked' : '' }} required>
                                <span class="flex items-center gap-2 font-bold text-rose-700 text-sm sm:text-base">
                                    <span class="w-3 h-3 rounded-full bg-rose-600 inline-block"></span>
                                    Barang Hilang
                                </span>
                                <span class="text-xs text-gray-500 mt-1">Saya kehilangan barang milik saya</span>
                            </label>

                            <label class="relative flex flex-col p-4 border rounded-xl cursor-pointer hover:border-emerald-400 has-[:checked]:border-emerald-600 has-[:checked]:bg-emerald-50/50 transition">
                                <input type="radio" name="jenis" value="ditemukan" class="sr-only" {{ old('jenis', request('jenis')) == 'ditemukan' ? 'checked' : '' }}>
                                <span class="flex items-center gap-2 font-bold text-emerald-700 text-sm sm:text-base">
                                    <span class="w-3 h-3 rounded-full bg-emerald-600 inline-block"></span>
                                    Barang Ditemukan
                                </span>
                                <span class="text-xs text-gray-500 mt-1">Saya menemukan barang milik orang lain</span>
                            </label>
                        </div>
                        <x-input-error :messages="$errors->get('jenis')" class="mt-2" />
                    </div>

                    <!-- NAMA BARANG -->
                    <div>
                        <x-input-label for="nama_barang" :value="__('Nama Barang *')" />
                        <x-text-input id="nama_barang" class="block mt-1 w-full" type="text" name="nama_barang" :value="old('nama_barang')" required placeholder="Contoh: Laptop ASUS Vivobook 14 Silver / Kunci Motor Honda" />
                        <x-input-error :messages="$errors->get('nama_barang')" class="mt-2" />
                    </div>

                    <!-- KATEGORI -->
                    <div>
                        <x-input-label for="kategori" :value="__('Kategori Barang *')" />
                        <select id="kategori" name="kategori" required class="block mt-1 w-full border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-lg shadow-sm text-sm">
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($kategoriList as $kat)
                                <option value="{{ $kat }}" {{ old('kategori') == $kat ? 'selected' : '' }}>{{ $kat }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('kategori')" class="mt-2" />
                    </div>

                    <!-- DESKRIPSI & CIRI KHUSUS -->
                    <div>
                        <x-input-label for="deskripsi" :value="__('Deskripsi & Ciri-Ciri Khusus *')" />
                        <textarea id="deskripsi" name="deskripsi" rows="4" required class="block mt-1 w-full border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-lg shadow-sm text-sm"
                                  placeholder="Jelaskan warna, stiker, merk, gantungan kunci, atau ciri khas lainnya agar pemilik/penemu mudah mengenali...">{{ old('deskripsi') }}</textarea>
                        <x-input-error :messages="$errors->get('deskripsi')" class="mt-2" />
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- LOKASI KEJADIAN -->
                        <div>
                            <x-input-label for="lokasi" :value="__('Lokasi Kehilangan / Ditemukan *')" />
                            <x-text-input id="lokasi" class="block mt-1 w-full" type="text" name="lokasi" :value="old('lokasi')" required placeholder="Contoh: Gedung Rektorat Lt. 2 / Lab Komputer 3" />
                            <x-input-error :messages="$errors->get('lokasi')" class="mt-2" />
                        </div>

                        <!-- TANGGAL KEJADIAN -->
                        <div>
                            <x-input-label for="tanggal" :value="__('Tanggal Kejadian *')" />
                            <x-text-input id="tanggal" class="block mt-1 w-full" type="date" name="tanggal" :value="old('tanggal', date('Y-m-d'))" required />
                            <x-input-error :messages="$errors->get('tanggal')" class="mt-2" />
                        </div>
                    </div>

                    <!-- KONTAK WHATSAPP -->
                    <div>
                        <x-input-label for="kontak" :value="__('Nomor WhatsApp untuk Kontak / Klaim *')" />
                        <x-text-input id="kontak" class="block mt-1 w-full" type="tel" name="kontak" :value="old('kontak', Auth::user()->no_wa)" required placeholder="Contoh: 081234567890" />
                        <p class="text-xs text-gray-500 mt-1">Nomor ini akan digunakan calon penemu/pemilik untuk menghubungi Anda langsung via WhatsApp.</p>
                        <x-input-error :messages="$errors->get('kontak')" class="mt-2" />
                    </div>

                    <!-- UPLOAD FOTO BARANG -->
                    <div>
                        <x-input-label for="foto" :value="__('Foto Barang (Opsional tapi Direkomendasikan)')" />
                        <input id="foto" type="file" name="foto" accept="image/*" class="block mt-1 w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 cursor-pointer" />
                        <p class="text-[11px] text-gray-400 mt-1">Maksimal ukuran file 2 MB. Format: JPG, PNG, WEBP.</p>
                        <x-input-error :messages="$errors->get('foto')" class="mt-2" />
                    </div>

                    <!-- TOMBOL AKSI -->
                    <div class="pt-4 border-t border-gray-100 flex items-center justify-end gap-3">
                        <a href="{{ route('barangs.my') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition">
                            Batal
                        </a>
                        <button type="submit" class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm rounded-lg shadow-sm transition">
                            Publikasikan Laporan
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</x-app-layout>
