<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AsetBuku extends Model
{
    protected $table = 'aset_buku';
    protected $primaryKey = 'id_aset';
    
    // Fixed: Updated to match db_perpustakaan_sma1pangururan structure  
    // Database columns: id_aset, id_buku, nomor_inventaris, kondisi_buku, catatan
    protected $fillable = ['id_buku', 'nomor_inventaris', 'kondisi_buku', 'catatan'];  
    
    // Database doesn't have timestamps
    public $timestamps = false;
    
    public function buku()
    {
        // Fixed: aset_buku.id_buku -> buku.id_buku
        return $this->belongsTo(Buku::class, 'id_buku', 'id_buku');
    }

    public function peminjaman()
    {
        // aset_buku.id_aset <- peminjaman.id_aset_buku
        return $this->hasMany(Peminjaman::class, 'id_aset_buku', 'id_aset');
    }
}
