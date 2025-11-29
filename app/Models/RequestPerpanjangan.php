<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequestPerpanjangan extends Model
{
    protected $table = 'request_perpanjangan';
    protected $primaryKey = 'id_request';
    
    protected $fillable = ['id_peminjaman', 'tanggal_request', 'tanggal_kembali_baru', 'alasan', 'status', 'catatan_admin', 'diproses_oleh'];

    protected $casts = [
        'tanggal_request' => 'datetime',
        'tanggal_kembali_baru' => 'date'
    ];

    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class, 'id_peminjaman', 'id_peminjaman');
    }

    public function diproses()
    {
        return $this->belongsTo(User::class, 'diproses_oleh', 'id_user');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeDisetujui($query)
    {
        return $query->where('status', 'disetujui');
    }

    public function scopeDitolak($query)
    {
        return $query->where('status', 'ditolak');
    }
}
