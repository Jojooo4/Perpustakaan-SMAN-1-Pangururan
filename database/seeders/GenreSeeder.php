<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Genre;

class GenreSeeder extends Seeder
{
    public function run(): void
    {
        $genres = [
            // Bidang Umum Pendidikan
            'Filsafat Pendidikan', 'Psikologi Pendidikan', 'Kurikulum', 'Penilaian & Evaluasi', 'Metode Pembelajaran',
            'Teknologi Pendidikan', 'Pendidikan Inklusif', 'Bimbingan & Konseling', 'Manajemen Pendidikan', 'Penelitian Pendidikan',
            // Sains & Matematika
            'Matematika', 'Statistika', 'Fisika', 'Kimia', 'Biologi', 'Astronomi', 'Ilmu Bumi & Geografi',
            // Bahasa & Sastra
            'Bahasa Indonesia', 'Bahasa Inggris', 'Bahasa Arab', 'Bahasa Mandarin', 'Bahasa Jepang', 'Linguistik', 'Sastra',
            // Sosial & Humaniora
            'Sejarah', 'Sosiologi', 'Antropologi', 'Ekonomi', 'Akuntansi', 'Kewirausahaan', 'Pendidikan Kewarganegaraan', 'Geografi',
            // Keagamaan
            'Pendidikan Agama Islam', 'Pendidikan Agama Kristen', 'Pendidikan Agama Katolik', 'Pendidikan Agama Buddha', 'Pendidikan Agama Hindu',
            // Seni & Olahraga
            'Seni Rupa', 'Seni Musik', 'Seni Tari', 'Seni Teater', 'Pendidikan Jasmani & Kesehatan',
            // TIK & Kejuruan
            'Teknologi Informasi', 'Pemrograman', 'Jaringan Komputer', 'Desain Grafis', 'Multimedia', 'Elektronika', 'Otomotif',
            // Sains Terapan
            'Kesehatan', 'Gizi', 'Pertanian', 'Peternakan', 'Perikanan', 'Lingkungan Hidup',
            // Umum
            'Pengembangan Diri', 'Keterampilan Hidup', 'Ensiklopedia', 'Referensi', 'Kamus',
            // Komik & Populer
            'Comedy', 'Slice of Life', 'Shounen', 'Shoujo', 'Seinen', 'Josei', 'Action', 'Adventure', 'Fantasy', 'Sci-Fi',
            'Mystery', 'Thriller', 'Horror', 'Romance', 'Drama', 'School', 'Sports', 'Supernatural', 'Historical', 'Mecha', 'Isekai'
        ];

        foreach ($genres as $nama) {
            Genre::firstOrCreate(['nama_genre' => $nama]);
        }
    }
}
