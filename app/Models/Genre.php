<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    protected $table = 'genre';
    protected $primaryKey = 'id_genre';
    
    protected $fillable = ['nama_genre', 'deskripsi'];

    public function bukus()
    {
        return $this->belongsToMany(Buku::class, 'buku_genre', 'id_genre', 'id_buku');
    }
}
