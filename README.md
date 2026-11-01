### ***CAMPUS LOST AND FOUND***

Role mahasiswa/user:

Kalo sebagai mahasiswa kita mengklik di landing page masuk sebagai Mahasiswa dan langsung masuk di halaman beranda. Di sini sistem menampilkan daftar barang hilang dan barang ditemukan. Dari beranda, mahasiswa bisa melakukan dua hal.

Yang pertama, mencari barang. Mahasiswa memilih atau memfilter daftar sesuai yang dicari, lalu langkah berikutnya tergantung jenis barangnya:

Kalau barang berstatus hilang, fotonya ditampilkan. Kalau mahasiswa menemukan barang itu, ia klik tombol “Hubungi via WA”, lalu WhatsApp terbuka langsung ke pemiliknya.
Kalau barang berstatus ditemukan, fotonya tidak ditampilkan supaya orang tidak bisa asal mengaku sebagai pemilik. Mahasiswa yang merasa itu barangnya datang ke pos (tempat penitipan barang temuan) membawa KTM dan menyebutkan ciri-cirinya, lalu dicek oleh petugas.

Yang kedua, melapor barang. Mahasiswa mengisi formulir berisi nama barang, status (hilang atau ditemukan), lokasi, deskripsi, foto, dan nomor WA. Setelah dikirim, sistem memeriksa isinya. Kalau ada yang kosong atau salah, muncul pesan error dan mahasiswa mengisi ulang. Kalau sudah benar, data disimpan ke database (tempat penyimpanan data) dan fotonya ke folder khusus, lalu muncul notifikasi sukses. Mahasiswa dikembalikan ke beranda dan laporannya sudah tampil di daftar. Kalau yang dilaporkan barang temuan, penemu juga menitipkan barangnya ke pos.

Role admin:

Admin masuk/mengklik di landing page sebagai Admin. Lalu mengisi username dan password, lalu sistem memeriksanya. Kalau salah, muncul pesan error dan admin mengulang. Kalau benar, sistem membuat session (penanda bahwa admin sudah login) dan admin masuk ke dashboard.

Di dashboard, admin bisa melihat semua laporan, termasuk foto barang temuan yang tidak bisa dilihat mahasiswa. Dari sini admin memilih salah satu aksi: mengubah status laporan (misalnya jadi sudah diserahkan atau diarsipkan), menghapus laporan beserta fotonya, atau logout. Setelah status diubah atau data dihapus, tabel di dashboard langsung diperbarui. Kalau logout, session dihapus dan admin kembali ke halaman login.

Admin juga berperan saat serah terima. Ketika pemilik datang ke pos, admin mencocokkan KTM dan ciri-ciri yang disebutkan dengan foto asli di dashboard. Kalau cocok, barang diserahkan dan laporan ditandai sudah diserahkan. Kalau tidak cocok, barang tidak diserahkan dan laporan tetap tampil di beranda.

Jadi, mahasiswa yang membuat dan mencari laporan, sedangkan admin yang mengelola laporan dan memastikan barang sampai ke pemilik yang benar. Semua data disimpan di satu database, makanya laporan dari mahasiswa langsung muncul di dashboard admin.
