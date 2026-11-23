<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Barang extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nama_barang',
        'jenis',
        'kategori',
        'deskripsi',
        'lokasi',
        'tanggal',
        'foto',
        'kontak',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'tanggal' => 'date',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * URL foto barang atau gambar ilustrasi kategori jika foto tidak diunggah.
     */
    public function getGambarUrlAttribute(): string
    {
        if ($this->hasRealFoto()) {
            return asset('storage/' . $this->foto);
        }

        $map = [
            'Elektronik' => 'elektronik.svg',
            'Dompet / Kartu' => 'dompet.svg',
            'Kunci' => 'kunci.svg',
            'Dokumen / Berkas' => 'dokumen.svg',
            'Pakaian / Aksesoris' => 'pakaian.svg',
            'Lainnya' => 'lainnya.svg',
        ];

        $filename = $map[$this->kategori] ?? 'lainnya.svg';
        return asset('images/placeholders/' . $filename);
    }

    /**
     * Memeriksa apakah barang memiliki foto asli yang valid di storage.
     */
    public function hasRealFoto(): bool
    {
        return !empty($this->foto) && file_exists(public_path('storage/' . $this->foto));
    }
}
