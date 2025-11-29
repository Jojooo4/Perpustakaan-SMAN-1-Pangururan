<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UlasanBuku extends Model
{
    protected $table = 'ulasan_buku';
    protected $primaryKey = 'id_ulasan';
    
    protected $fillable = ['kode_buku', 'id_user', 'rating', 'komentar'];
    
    public $timestamps = false; // Disable if table has no created_at/updated_at
    
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
        return $this->belongsTo(Buku::class, 'kode_buku', 'kode_buku');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function scopeRecent($query)
    {
        return $query->orderBy('id_ulasan', 'desc'); // Use id instead of tanggal_ulasan
    }
}
