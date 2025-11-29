<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    protected $table = 'buku';
    protected $primaryKey = 'kode_buku';
    public $incrementing = false;
    protected $keyType = 'string';
    
    protected $fillable = ['kode_buku', 'judul', 'nama_pengarang', 'penerbit', 'tahun_terbit', 'jumlah_halaman', 'gambar', 'stok_tersedia'];

    public function asetBuku()
    {
        return $this->hasMany(AsetBuku::class, 'kode_buku', 'kode_buku');
    }

    public function genres()
    {
        return $this->belongsToMany(Genre::class, 'buku_genre', 'kode_buku', 'id_genre');
    }

    public function ulasan()
    {
        return $this->hasMany(UlasanBuku::class, 'kode_buku', 'kode_buku');
    }

    public function scopeSearch($query, $search)
    {
        return $query->where('judul', 'like', "%{$search}%")
                    ->orWhere('nama_pengarang', 'like', "%{$search}%")
                    ->orWhere('penerbit', 'like', "%{$search}%");
    }

    public function scopeTersedia($query)
    {
        return $query->where('stok_tersedia', '>', 0);
    }

    public function getRataRating()
    {
        return $this->ulasan()->avg('rating') ?? 0;
    }
}
