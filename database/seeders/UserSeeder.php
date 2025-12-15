<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Generate 10 Admin, 10 Petugas, 10 Pengunjung
        $this->seedAdmins(10);
        $this->seedPetugas(10);
        $this->seedPengunjung(10);
    }

    private function seedAdmins(int $count): void
    {
        for ($i = 1; $i <= $count; $i++) {
            User::create([
                'username' => 'ADMIN'.Str::padLeft((string)$i, 3, '0'),
                'password' => Hash::make('password123'),
                'nama' => 'Admin '.$i,
                'role' => 'admin',
                'tipe_anggota' => 'Staf',
                'status_keanggotaan' => 'Aktif',
            ]);
        }
    }

    private function seedPetugas(int $count): void
    {
        for ($i = 1; $i <= $count; $i++) {
            User::create([
                'username' => 'PETUGAS'.Str::padLeft((string)$i, 3, '0'),
                'password' => Hash::make('password123'),
                'nama' => 'Petugas '.$i,
                'role' => 'petugas',
                'tipe_anggota' => 'Staf',
                'status_keanggotaan' => 'Aktif',
            ]);
        }
    }

    private function seedPengunjung(int $count): void
    {
        $kelasList = ['X-A1', 'X-B2', 'XI-A1', 'XI-B2', 'XII-A1', 'XII-B2'];
        for ($i = 1; $i <= $count; $i++) {
            $kelas = $kelasList[array_rand($kelasList)];
            User::create([
                'username' => 'SIS'.Str::padLeft((string)$i, 4, '0'),
                'password' => Hash::make('password123'),
                'nama' => 'Siswa '.$i,
                'role' => 'pengunjung',
                'tipe_anggota' => 'Siswa',
                'kelas' => $kelas,
                'status_keanggotaan' => 'Aktif',
            ]);
        }
    }
}
