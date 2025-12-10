<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequestPerpanjangan extends Model
{
    protected $table = 'request_perpanjangan';
    protected $primaryKey = 'id_request';
    
    public $timestamps = false; // No created_at/updated_at in table
    
    protected $fillable = ['id_peminjaman', 'tanggal_request', 'tanggal_perpanjangan_baru', 'catatan', 'status', 'diproses_oleh'];

    protected $casts = [
        'tanggal_request' => 'datetime',
        'tanggal_perpanjangan_baru' => 'date'
    ];

    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class, 'id_peminjaman', 'id_peminjaman');
    }

    public function diproses()
    {
        return $this->belongsTo(User::class, 'diproses_oleh', 'id');
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
