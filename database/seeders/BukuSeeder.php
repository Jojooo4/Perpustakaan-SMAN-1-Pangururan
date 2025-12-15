<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Buku;
use App\Models\Genre;
use Faker\Factory as FakerFactory;

class BukuSeeder extends Seeder
{
    public function run(): void
    {
        $faker = FakerFactory::create('id_ID');

        // Ambil semua genre yang sudah ada
        $genreIds = Genre::pluck('id_genre')->all();
        if (empty($genreIds)) {
            // Jika belum ada genre, buat minimal beberapa
            $defaults = ['Matematika', 'Bahasa Indonesia', 'Sejarah', 'Fisika', 'Kimia'];
            foreach ($defaults as $g) {
                $genreIds[] = Genre::firstOrCreate(['nama_genre' => $g])->id_genre;
            }
        }

        // Buat 50 buku dummy
        for ($i = 1; $i <= 50; $i++) {
            $judul = $faker->unique()->sentence(3);
            $pengarang = $faker->name();
            $penerbit = $faker->company();
            $tahun = $faker->numberBetween(1980, 2025);
            $halaman = $faker->numberBetween(80, 600);
            $stok = $faker->numberBetween(3, 20);

            $buku = Buku::create([
                'judul' => strtoupper($judul),
                'nama_pengarang' => $pengarang,
                'penerbit' => $penerbit,
                'tahun_terbit' => $tahun,
                'jumlah_halaman' => $halaman,
                'gambar' => null,
                'stok_tersedia' => $stok,
            ]);

            // Pasangkan 1-3 genre acak
            $attachCount = random_int(1, 3);
            shuffle($genreIds);
            $buku->genres()->attach(array_slice($genreIds, 0, $attachCount));
        }
    }
}
