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
    protected $fillable = [
        'username',
        'nama',
        'password',
        'role',
        // Fixed: Match ACTUAL database structure from phpMyAdmin
        'tipe_anggota',      // enum('Siswa', 'Guru', 'Kepala Sekolah', 'Staf', 'Umum')
        'kelas',             // varchar(20)
        'status_keanggotaan', // enum('Aktif', 'Tidak Aktif', 'Dibekukan')
        // NOTE: database does NOT have 'role' column!
        'foto_profil',
        // NOTE: id_user is NOT in fillable because it's AUTO_INCREMENT
    ];

    /**
     * Primary key is id_user (not standard 'id')
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

    /**
     * Default attribute values.
     */
    protected $attributes = [
        'status_keanggotaan' => 'Aktif',
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
    // NOTE: Database doesn't have 'role' column, using tipe_anggota instead
    // Assuming: 'Admin'/'Petugas' in tipe_anggota, while Siswa/Guru/etc are regular users
    public function isAdmin()
    {
        // Check if there's a column that indicates admin status
        if (isset($this->attributes['role'])) {
            return $this->attributes['role'] === 'admin';
        }
        // Fallback: maybe admin is indicated by tipe_anggota
        return isset($this->attributes['tipe_anggota']) && 
               in_array($this->attributes['tipe_anggota'], ['Admin']);
    }

    public function isPetugas()
    {
        if (isset($this->attributes['role'])) {
            return $this->attributes['role'] === 'petugas';
        }
        return isset($this->attributes['tipe_anggota']) && 
               in_array($this->attributes['tipe_anggota'], ['Petugas']);
    }

    public function isPengunjung()
    {
        if (isset($this->attributes['role'])) {
            return $this->attributes['role'] === 'pengunjung';
        }
        // Siswa, Guru, dll are regular pengunjung/visitors
        return isset($this->attributes['tipe_anggota']) && 
               in_array($this->attributes['tipe_anggota'], ['Siswa', 'Guru']);
    }
}
