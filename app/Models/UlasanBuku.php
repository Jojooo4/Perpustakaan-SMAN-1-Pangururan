<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UlasanBuku extends Model
{
    protected $table = 'ulasan_buku';
    protected $primaryKey = 'id_ulasan';
    
    // Fixed: database uses kode_buku and nomor_identitas, not id_buku and id_user
    protected $fillable = ['kode_buku', 'nomor_identitas', 'rating', 'komentar'];
    
    // Fixed: table has created_at only (no updated_at)
    const CREATED_AT = 'created_at';
    const UPDATED_AT = null;
    
    protected $casts = ['rating' => 'integer'];
    
    // Map 'ulasan' attribute to 'komentar' column for backward compatibility
    protected $appends = ['ulasan'];
    
    public function getUlasanAttribute()
    {
        return $this->komentar;
    }
    
    public function setUlasanAttribute($value)
    {
        $this->attributes['komentar'] = $value;
    }

    public function buku()
    {
        // Fixed: ulasan_buku.kode_buku -> buku.kode_buku
        return $this->belongsTo(Buku::class, 'kode_buku', 'kode_buku');
    }

    public function pengunjung()
    {
        // Fixed: database uses nomor_identitas, not id_user
        return $this->belongsTo(Pengunjung::class, 'nomor_identitas', 'nomor_identitas');
    }

    public function scopeRecent($query)
    {
        return $query->orderBy('created_at', 'desc');
    }
}
