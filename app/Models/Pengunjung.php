<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengunjung extends Model
{
    protected $table = 'pengunjung';
    protected $primaryKey = 'nomor_identitas';
    public $incrementing = false;
    protected $keyType = 'string';
    
    protected $fillable = [
        'nomor_identitas',
        'nama',
        'tipe_anggota',
        'kelas',
        'status_keanggotaan',
        'id_user'
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class, 'nomor_identitas', 'nomor_identitas');
    }

    public function ulasan()
    {
        return $this->hasMany(UlasanBuku::class, 'nomor_identitas', 'nomor_identitas');
    }

    // Scopes
    public function scopeAktif($query)
    {
        return $query->where('status_keanggotaan', 'Aktif');
    }

    public function scopeSiswa($query)
    {
        return $query->where('tipe_anggota', 'Siswa');
    }
}
