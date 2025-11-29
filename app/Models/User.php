<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    // adjust fillable to match your users table columns
    protected $fillable = [
        'username',
        'nama',
        'email',
        'password',
        'role',
        'foto_profil',
    ];

    /**
     * If your users table primary key is `id_user` instead of `id`, set it here.
     */
    protected $primaryKey = 'id_user';
    public $incrementing = true;
    protected $keyType = 'int';

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Relationships
    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class, 'id_user', 'id_user');
    }

    public function ulasan()
    {
        return $this->hasMany(UlasanBuku::class, 'id_user', 'id_user');
    }

    // Role Helpers
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isPetugas()
    {
        return $this->role === 'petugas';
    }

    public function isPengunjung()
    {
        return $this->role === 'pengunjung';
    }
}
