<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Peminjaman extends Model
{
    protected $table = 'peminjaman';
    protected $primaryKey = 'id_peminjaman';
    
    
    // Disable timestamps - table doesn't have created_at/updated_at
    public $timestamps = false;
    
    // Database columns: id_user, id_aset_buku (NOT id_aset!)
    protected $fillable = ['id_user', 'id_aset_buku', 'tanggal_pinjam', 'tanggal_jatuh_tempo', 'tanggal_kembali', 'status_peminjaman', 'denda'];

    protected $casts = [
        'tanggal_pinjam' => 'date',
        'tanggal_jatuh_tempo' => 'date',
        'tanggal_kembali' => 'date',
        'denda' => 'integer',
    ];

    public function user()
    {
        // peminjaman.id_user -> users.id_user
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
        // Fixed: use denda_per_hari from aturan_perpustakaan (default 500 from schema)
        $dendaPerHari = \DB::table('aturan_perpustakaan')->where('nama_aturan', 'denda_per_hari')->value('isi_aturan') ?? 500;
        
        if ($this->tanggal_kembali && $this->tanggal_jatuh_tempo) {
            $jatuhTempo = Carbon::parse($this->tanggal_jatuh_tempo);
            $kembali = Carbon::parse($this->tanggal_kembali);
            $hariTerlambat = max(0, $kembali->diffInDays($jatuhTempo, false) * -1);
            return $hariTerlambat * $dendaPerHari;
        }
        
        if ($this->status_peminjaman === 'Dipinjam') {
            $jatuhTempo = Carbon::parse($this->tanggal_jatuh_tempo);
            $hariTerlambat = max(0, now()->diffInDays($jatuhTempo, false) * -1);
            return $hariTerlambat * $dendaPerHari;
        }
        
        return 0;
    }

    public function isTerlambat()
    {
        return $this->status_peminjaman === 'Dipinjam' && 
               Carbon::parse($this->tanggal_jatuh_tempo)->isPast();
    }
}
