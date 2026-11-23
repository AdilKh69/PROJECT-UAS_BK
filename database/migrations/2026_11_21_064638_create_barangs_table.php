<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('barangs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('nama_barang');
            $table->enum('jenis', ['hilang', 'ditemukan'])->default('hilang'); // jenis laporan
            $table->string('kategori')->default('Lainnya'); // Elektronik, Dokumen/Kartu, Dompet/Uang, Pakaian/Aksesoris, Kunci, dll.
            $table->text('deskripsi');
            $table->string('lokasi'); // Lokasi kehilangan / penemuan
            $table->date('tanggal'); // Tanggal kejadian
            $table->string('foto')->nullable(); // Foto barang (path)
            $table->string('kontak')->nullable(); // No WA pelapor
            $table->enum('status', ['menunggu', 'terverifikasi', 'selesai'])->default('terverifikasi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barangs');
    }
};
