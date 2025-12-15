<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Urutan penting: Genre -> Users -> Buku -> AsetBuku
        $this->call([
            GenreSeeder::class,
            UserSeeder::class,
            BukuSeeder::class,
            AsetBukuSeeder::class,
        ]);
    }
}
