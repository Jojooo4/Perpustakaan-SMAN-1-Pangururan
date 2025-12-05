<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequestPeminjaman extends Model
{
    protected $table = 'request_peminjaman';
    protected $primaryKey = 'id_request';
    
    public $timestamps = false;
    
    protected $fillable = ['id_user', 'kode_buku', 'status', 'tanggal_request', 'diproses_oleh', 'catatan_admin'];
    
    protected $casts = [
        'tanggal_request' => 'datetime'
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
    
    public function buku()
    {
        return $this->belongsTo(Buku::class, 'kode_buku', 'kode_buku');
    }
    
    public function petugas()
    {
        return $this->belongsTo(User::class, 'diproses_oleh', 'id_user');
    }
}
