<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class AdminController extends Controller
{
    /**
     * Tampilkan Halaman Utama Panel Administrator.
     */
    public function dashboard(Request $request): View
    {
        // 1. Data Statistik Metrik Kampus
        $stats = [
            'totalSemua' => Barang::count(),
            'totalHariIni' => Barang::whereDate('created_at', today())->count(),
            'totalMenunggu' => Barang::where('status', 'menunggu')->count(),
            'totalHilangAktif' => Barang::where('jenis', 'hilang')->where('status', '!=', 'selesai')->count(),
            'totalTemuanAktif' => Barang::where('jenis', 'ditemukan')->where('status', '!=', 'selesai')->count(),
            'totalSelesai' => Barang::where('status', 'selesai')->count(),
            'totalMahasiswa' => User::where('role', 'mahasiswa')->count(),
        ];

        // 2. Query Data Laporan dengan Filter & Pencarian
        $query = Barang::with('user')->latest();

        if ($request->filled('jenis') && in_array($request->jenis, ['hilang', 'ditemukan'])) {
            $query->where('jenis', $request->jenis);
        }

        if ($request->filled('status') && in_array($request->status, ['menunggu', 'terverifikasi', 'selesai'])) {
            $query->where('status', $request->status);
        }

        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function ($q) use ($search) {
                $q->where('nama_barang', 'like', "%{$search}%")
                  ->orWhere('lokasi', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($u) use ($search) {
                      $u->where('name', 'like', "%{$search}%")
                        ->orWhere('npm', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        $barangs = $query->paginate(10)->withQueryString();

        // 3. Data Mahasiswa Terdaftar Terbaru
        $mahasiswas = User::where('role', 'mahasiswa')
            ->withCount('barangs')
            ->latest()
            ->take(8)
            ->get();

        return view('admin.dashboard', compact('stats', 'barangs', 'mahasiswas'));
    }

    /**
     * Verifikasi cepat laporan (menyetujui laporan agar berstatus terverifikasi).
     */
    public function verify(Barang $barang): RedirectResponse
    {
        $barang->update(['status' => 'terverifikasi']);

        return back()->with('success', "Laporan '{$barang->nama_barang}' berhasil diverifikasi!");
    }

    /**
     * Tandai laporan selesai (barang telah diambil / dikembalikan ke pemilik).
     */
    public function complete(Barang $barang): RedirectResponse
    {
        $barang->update(['status' => 'selesai']);

        return back()->with('success', "Laporan '{$barang->nama_barang}' ditandai Selesai / Dikembalikan.");
    }

    /**
     * Hapus laporan barang oleh admin (misal spam atau laporan palsu).
     */
    public function destroy(Barang $barang): RedirectResponse
    {
        if ($barang->foto && Storage::disk('public')->exists($barang->foto)) {
            Storage::disk('public')->delete($barang->foto);
        }

        $nama = $barang->nama_barang;
        $barang->delete();

        return back()->with('success', "Laporan '{$nama}' berhasil dihapus oleh Admin.");
    }
}
