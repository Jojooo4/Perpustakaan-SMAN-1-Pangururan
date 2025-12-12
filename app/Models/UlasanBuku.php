<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UlasanBuku extends Model
{
    protected $table = 'ulasan_buku';
    protected $primaryKey = 'id_ulasan';
    
    // Use id_buku and id_user to match current schema
    protected $fillable = ['id_buku', 'id_user', 'rating', 'komentar'];
    
    // Disable timestamps (table doesn't have created_at/updated_at)
    public $timestamps = false;
    
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
        return $this->belongsTo(Buku::class, 'id_buku', 'id_buku');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function scopeRecent($query)
    {
        return $query->orderBy('created_at', 'desc');
    }
}
