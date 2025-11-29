<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Peminjaman extends Model
{
    protected $table = 'peminjaman';
    protected $primaryKey = 'id_peminjaman';
    
    public $timestamps = false; // Disable timestamps if table doesn't have created_at/updated_at
    
    protected $fillable = ['id_user', 'id_aset_buku', 'tanggal_pinjam', 'tanggal_jatuh_tempo', 'tanggal_kembali', 'status_peminjaman', 'denda', 'denda_lunas'];

    protected $casts = [
        'tanggal_pinjam' => 'date',
        'tanggal_jatuh_tempo' => 'date',
        'tanggal_kembali' => 'date',
        'denda' => 'decimal:2',
        'denda_lunas' => 'boolean'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function asetBuku()
    {
        // peminjaman.id_aset_buku -> aset_buku.id_aset
        return $this->belongsTo(AsetBuku::class, 'id_aset_buku', 'id_aset');
    }

    public function requestPerpanjangan()
    {
        return $this->hasMany(RequestPerpanjangan::class, 'id_peminjaman', 'id_peminjaman');
    }

    public function scopeAktif($query)
    {
        return $query->where('status_peminjaman', 'Dipinjam');
    }

    public function scopeTerlambat($query)
    {
        return $query->where('status_peminjaman', 'Terlambat');
    }

    public function scopeDikembalikan($query)
    {
        return $query->where('status_peminjaman', 'Dikembalikan');
    }

    public function hitungDenda()
    {
        if ($this->tanggal_kembali && $this->tanggal_jatuh_tempo) {
            $jatuhTempo = Carbon::parse($this->tanggal_jatuh_tempo);
            $kembali = Carbon::parse($this->tanggal_kembali);
            $hariTerlambat = max(0, $kembali->diffInDays($jatuhTempo, false) * -1);
            return $hariTerlambat * 1000;
        }
        
        if ($this->status_peminjaman === 'Dipinjam') {
            $jatuhTempo = Carbon::parse($this->tanggal_jatuh_tempo);
            $hariTerlambat = max(0, now()->diffInDays($jatuhTempo, false) * -1);
            return $hariTerlambat * 1000;
        }
        
        return 0;
    }

    public function isTerlambat()
    {
        return $this->status_peminjaman === 'Dipinjam' && 
               Carbon::parse($this->tanggal_jatuh_tempo)->isPast();
    }
}
