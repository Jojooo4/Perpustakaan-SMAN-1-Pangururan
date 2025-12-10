<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogAktivitas extends Model
{
    protected $table = 'log_aktivitas';
    protected $primaryKey = 'id_log';
    
    public $timestamps = false;
    
    protected $fillable = [
        'id_user',
        'username',
        'nama_tabel',
        'operasi',
        'deskripsi',
        'id_terkait',
        'data_lama',
        'data_baru'
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    // Scopes for filtering
    public function scopeByTable($query, $table)
    {
        return $query->where('nama_tabel', $table);
    }

    public function scopeByOperation($query, $operation)
    {
        return $query->where('operasi', $operation);
    }

    public function scopeByUser($query, $userId)
    {
        return $query->where('id_user', $userId);
    }

    public function scopeRecent($query, $days = 30)
    {
        return $query->where('timestamp', '>=', now()->subDays($days));
    }
}
