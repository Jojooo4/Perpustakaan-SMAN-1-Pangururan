<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{Buku, AsetBuku};

class AsetBukuSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil semua buku yang sudah ada
        $books = Buku::all();

        foreach ($books as $book) {
            // Cek berapa aset yang sudah ada untuk buku ini
            $existingCount = AsetBuku::where('id_buku', $book->id_buku)->count();
            
            // Buat aset sejumlah stok yang tersedia, minus yang sudah ada
            $stokTersedia = $book->stok_tersedia;
            $needToCreate = $stokTersedia - $existingCount;
            
            if ($needToCreate <= 0) {
                continue; // Skip jika sudah cukup atau lebih
            }
            
            // Mulai dari nomor setelah yang terakhir
            $startNumber = $existingCount + 1;
            
            for ($i = $startNumber; $i <= $startNumber + $needToCreate - 1; $i++) {
                AsetBuku::create([
                    'id_buku' => $book->id_buku,
                    'nomor_inventaris' => sprintf('BK-%03d-%03d', $book->id_buku, $i),
                    'kondisi_buku' => 'Baik',
                    'catatan' => 'Auto-generated dari stok awal'
                ]);
            }
        }

        $this->command->info('Aset buku berhasil di-seed untuk semua buku!');
    }
}
