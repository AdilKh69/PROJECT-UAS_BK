<?php

namespace Database\Seeders;

use App\Models\Barang;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Akun Admin
        $admin = User::firstOrCreate(
            ['email' => 'admin@unsil.ac.id'],
            [
                'name' => 'Admin Lost & Found UNSIL',
                'npm' => 'ADMIN01',
                'no_wa' => '081234567890',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        // 2. Akun Mahasiswa
        $mahasiswa = User::firstOrCreate(
            ['email' => 'mahasiswa@unsil.ac.id'],
            [
                'name' => 'Fajar Pratama',
                'npm' => '217006001',
                'no_wa' => '089876543210',
                'password' => Hash::make('password'),
                'role' => 'mahasiswa',
            ]
        );

        $mahasiswa2 = User::firstOrCreate(
            ['email' => 'anisa@unsil.ac.id'],
            [
                'name' => 'Anisa Rahmawati',
                'npm' => '227006045',
                'no_wa' => '085712345678',
                'password' => Hash::make('password'),
                'role' => 'mahasiswa',
            ]
        );

        // 3. Sample Data Barang Hilang & Ditemukan
        Barang::create([
            'user_id' => $mahasiswa->id,
            'nama_barang' => 'Laptop ASUS Vivobook 14 Silver',
            'jenis' => 'hilang',
            'kategori' => 'Elektronik',
            'deskripsi' => 'Laptop tertinggal di area kursi tunggu depan ruang BAKP Rektorat. Terdapat stiker anime One Piece di bagian cover depan dan gantungan flashdisk.',
            'lokasi' => 'Gedung Rektorat Lt. 2 (Depan BAKP)',
            'tanggal' => now()->subDays(1),
            'kontak' => '089876543210',
            'status' => 'terverifikasi',
        ]);

        Barang::create([
            'user_id' => $mahasiswa2->id,
            'nama_barang' => 'Dompet Kulit Cokelat & KTM UNSIL',
            'jenis' => 'ditemukan',
            'kategori' => 'Dompet / Kartu',
            'deskripsi' => 'Ditemukan dompet kulit warna cokelat tua berisi KTM atas nama Dika Surya, SIM C, dan sejumlah uang tunai. Barang saat ini saya titipkan di Pos Satpam Gerbang Utama UNSIL.',
            'lokasi' => 'Masjid Al-Muhajirin Kampus 1',
            'tanggal' => now(),
            'kontak' => '085712345678',
            'status' => 'terverifikasi',
        ]);

        Barang::create([
            'user_id' => $admin->id,
            'nama_barang' => 'Kunci Motor Honda Vario (Gantungan Biru)',
            'jenis' => 'ditemukan',
            'kategori' => 'Kunci',
            'deskripsi' => 'Kunci motor masih menempel di stop kontak motor Vario hitam plat Z. Sekarang kunci diamankan oleh petugas keamanan parkiran.',
            'lokasi' => 'Parkiran Gedung Perkuliahan Bersama (GPB)',
            'tanggal' => now(),
            'kontak' => '081234567890',
            'status' => 'terverifikasi',
        ]);

        Barang::create([
            'user_id' => $mahasiswa->id,
            'nama_barang' => 'Tumbler Minum Stainless Corkcicle Hitam',
            'jenis' => 'hilang',
            'kategori' => 'Lainnya',
            'deskripsi' => 'Botol minum tertinggal di bawah meja baris ketiga setelah kuliah Pemrograman Web.',
            'lokasi' => 'Ruang Lab Komputer 3 Fak. Teknik',
            'tanggal' => now()->subDays(2),
            'kontak' => '089876543210',
            'status' => 'terverifikasi',
        ]);
    }
}
