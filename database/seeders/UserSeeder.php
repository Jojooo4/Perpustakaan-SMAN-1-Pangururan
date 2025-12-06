<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin account
        User::create([
            'username' => 'admin',
            'password' => Hash::make('password123'),
            'nama' => 'Administrator',
            'email' => 'admin@perpustakaan.com',
            'role' => 'admin',
            'nomor_identitas' => '12345',
            'tipe_anggota' => 'Staf',
            'status_keanggotaan' => 'Aktif',
        ]);

        // Petugas account
        User::create([
            'username' => 'petugas',
            'password' => Hash::make('password123'),
            'nama' => 'Petugas Perpustakaan',
            'email' => 'petugas@perpustakaan.com',
            'role' => 'petugas',
            'nomor_identitas' => '54321',
            'tipe_anggota' => 'Staf',
            'status_keanggotaan' => 'Aktif',
        ]);

        // Pengunjung Siswa
        User::create([
            'username' => 'siswa123',
            'password' => Hash::make('password123'),
            'nama' => 'Siswa Testing',
            'email' => 'siswa@perpustakaan.com',
            'role' => 'pengunjung',
            'nomor_identitas' => '11223344',
            'tipe_anggota' => 'Siswa',
            'kelas' => 'X-A1',
            'status_keanggotaan' => 'Aktif',
        ]);

        // Pengunjung Guru
        User::create([
            'username' => 'guru123',
            'password' => Hash::make('password123'),
            'nama' => 'Guru Testing',
            'email' => 'guru@perpustakaan.com',
            'role' => 'pengunjung',
            'nomor_identitas' => '99887766',
            'tipe_anggota' => 'Guru',
            'status_keanggotaan' => 'Aktif',
        ]);
    }
}
