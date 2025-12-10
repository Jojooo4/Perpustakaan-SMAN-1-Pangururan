<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    use HasFactory;

    protected $table = 'buku';
    
    // User changed database: id_buku is now INT AUTO_INCREMENT
    protected $primaryKey = 'id_buku';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'judul',
        'nama_pengarang',
        'penerbit',
        'tahun_terbit',
        'jumlah_halaman',
        'gambar',
        'stok_tersedia',
    ];

    public function asetBuku()
    {
        return $this->hasMany(AsetBuku::class, 'id_buku', 'id_buku');
    }

    public function genres()
    {
        return $this->belongsToMany(Genre::class, 'buku_genre', 'id_buku', 'id_genre');
    }

    public function ulasan()
    {
        return $this->hasMany(UlasanBuku::class, 'id_buku', 'id_buku');
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
