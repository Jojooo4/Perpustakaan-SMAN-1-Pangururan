<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AsetBuku extends Model
{
    protected $table = 'aset_buku';
    protected $primaryKey = 'id_aset'; // FIX: Primary key is id_aset, not id_aset_buku
    
    protected $fillable = ['kode_buku', 'nomor_inventaris', 'kondisi_buku', 'catatan'];
    
    public $timestamps = false;
    
    // Note: If your aset_buku table has a status column with different name, update fillable above

    public function buku()
    {
        return $this->belongsTo(Buku::class, 'kode_buku', 'kode_buku');
    }

    public function peminjaman()
    {
        // aset_buku.id_aset <- peminjaman.id_aset_buku
        return $this->hasMany(Peminjaman::class, 'id_aset_buku', 'id_aset');
    }
    
    // Note: Uncomment these if your database has a status column
    // public function scopeTersedia($query)
    // {
    //     return $query->where('status_buku', 'Tersedia');
    // }
    
    // public function scopeDipinjam($query)
    // {
    //     return $query->where('status_buku', 'Dipinjam');
    // }
}
