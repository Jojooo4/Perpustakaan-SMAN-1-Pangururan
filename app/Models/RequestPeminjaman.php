<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequestPeminjaman extends Model
{
    protected $table = 'request_peminjaman';
    protected $primaryKey = 'id_request';
    
    protected $fillable = ['id_user', 'id_buku', 'status', 'tanggal_request', 'diproses_oleh', 'tanggal_diproses', 'catatan_admin'];
    
    public $timestamps = false;
    
    protected $casts = [
        'tanggal_request' => 'datetime',
        'tanggal_diproses' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function buku()
    {
        return $this->belongsTo(Buku::class, 'id_buku', 'id_buku');
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
