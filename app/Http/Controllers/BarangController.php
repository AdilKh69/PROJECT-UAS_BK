<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class BarangController extends Controller
{
    /**
     * Menampilkan katalog publik barang hilang & ditemukan.
     */
    public function index(Request $request): View
    {
        $query = Barang::with('user')->latest();

        // Filter berdasarkan jenis laporan (hilang / ditemukan)
        if ($request->filled('jenis') && in_array($request->jenis, ['hilang', 'ditemukan'])) {
            $query->where('jenis', $request->jenis);
        }

        // Filter berdasarkan kategori
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        // Filter status (default hanya yang belum selesai, atau tampilkan semua)
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Pencarian nama barang, deskripsi, atau lokasi
        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function ($q) use ($search) {
                $q->where('nama_barang', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%")
                  ->orWhere('lokasi', 'like', "%{$search}%");
            });
        }

        $barangs = $query->paginate(9)->withQueryString();

        $kategoriList = [
            'Elektronik',
            'Dompet / Kartu',
            'Kunci',
            'Dokumen / Berkas',
            'Pakaian / Aksesoris',
            'Lainnya',
        ];

        return view('beranda', compact('barangs', 'kategoriList'));
    }

    /**
     * Tampilkan form pembuatan laporan barang baru.
     */
    public function create(): View
    {
        $kategoriList = [
            'Elektronik',
            'Dompet / Kartu',
            'Kunci',
            'Dokumen / Berkas',
            'Pakaian / Aksesoris',
            'Lainnya',
        ];

        return view('barangs.create', compact('kategoriList'));
    }

    /**
     * Simpan laporan baru ke database beserta upload foto.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama_barang' => ['required', 'string', 'max:255'],
            'jenis' => ['required', 'in:hilang,ditemukan'],
            'kategori' => ['required', 'string', 'max:100'],
            'deskripsi' => ['required', 'string'],
            'lokasi' => ['required', 'string', 'max:255'],
            'tanggal' => ['required', 'date'],
            'kontak' => ['required', 'string', 'max:50'],
            'foto' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('barangs', 'public');
        }

        $barang = Barang::create([
            'user_id' => Auth::id(),
            'nama_barang' => $validated['nama_barang'],
            'jenis' => $validated['jenis'],
            'kategori' => $validated['kategori'],
            'deskripsi' => $validated['deskripsi'],
            'lokasi' => $validated['lokasi'],
            'tanggal' => $validated['tanggal'],
            'kontak' => $validated['kontak'],
            'foto' => $fotoPath,
            'status' => 'terverifikasi',
        ]);

        return redirect()->route('barangs.show', $barang)
            ->with('success', 'Laporan barang berhasil dipublikasikan!');
    }

    /**
     * Tampilkan detail satu barang.
     */
    public function show(Barang $barang): View
    {
        $barang->load('user');
        return view('barangs.show', compact('barang'));
    }

    /**
     * Menampilkan daftar laporan milik pengguna saat ini (atau semua laporan untuk admin).
     */
    public function myReports(): View
    {
        $user = Auth::user();

        if ($user->isAdmin()) {
            $barangs = Barang::with('user')->latest()->paginate(10);
        } else {
            $barangs = Barang::with('user')->where('user_id', $user->id)->latest()->paginate(10);
        }

        return view('barangs.my-reports', compact('barangs'));
    }

    /**
     * Tampilkan form edit laporan.
     */
    public function edit(Barang $barang): View
    {
        $user = Auth::user();
        if ($barang->user_id !== $user->id && !$user->isAdmin()) {
            abort(403, 'Anda tidak memiliki hak untuk mengedit laporan ini.');
        }

        $kategoriList = [
            'Elektronik',
            'Dompet / Kartu',
            'Kunci',
            'Dokumen / Berkas',
            'Pakaian / Aksesoris',
            'Lainnya',
        ];

        return view('barangs.edit', compact('barang', 'kategoriList'));
    }

    /**
     * Simpan pembaruan laporan.
     */
    public function update(Request $request, Barang $barang): RedirectResponse
    {
        $user = Auth::user();
        if ($barang->user_id !== $user->id && !$user->isAdmin()) {
            abort(403, 'Anda tidak memiliki hak untuk mengubah laporan ini.');
        }

        $validated = $request->validate([
            'nama_barang' => ['required', 'string', 'max:255'],
            'jenis' => ['required', 'in:hilang,ditemukan'],
            'kategori' => ['required', 'string', 'max:100'],
            'deskripsi' => ['required', 'string'],
            'lokasi' => ['required', 'string', 'max:255'],
            'tanggal' => ['required', 'date'],
            'kontak' => ['required', 'string', 'max:50'],
            'status' => ['required', 'in:menunggu,terverifikasi,selesai'],
            'foto' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ]);

        if ($request->hasFile('foto')) {
            if ($barang->foto && Storage::disk('public')->exists($barang->foto)) {
                Storage::disk('public')->delete($barang->foto);
            }
            $validated['foto'] = $request->file('foto')->store('barangs', 'public');
        }

        $barang->update($validated);

        return redirect()->route('barangs.show', $barang)
            ->with('success', 'Laporan berhasil diperbarui.');
    }

    /**
     * Hapus laporan.
     */
    public function destroy(Barang $barang): RedirectResponse
    {
        $user = Auth::user();
        if ($barang->user_id !== $user->id && !$user->isAdmin()) {
            abort(403, 'Anda tidak memiliki hak untuk menghapus laporan ini.');
        }

        if ($barang->foto && Storage::disk('public')->exists($barang->foto)) {
            Storage::disk('public')->delete($barang->foto);
        }

        $barang->delete();

        return redirect()->route('barangs.my')
            ->with('success', 'Laporan barang berhasil dihapus.');
    }

    /**
     * Cepat ubah status (misal tandai sudah ditemukan / selesai).
     */
    public function updateStatus(Request $request, Barang $barang): RedirectResponse
    {
        $user = Auth::user();
        if ($barang->user_id !== $user->id && !$user->isAdmin()) {
            abort(403, 'Aksi tidak diizinkan.');
        }

        $request->validate([
            'status' => ['required', 'in:menunggu,terverifikasi,selesai'],
        ]);

        $barang->update(['status' => $request->status]);

        return back()->with('success', 'Status laporan berhasil diubah!');
    }
}
