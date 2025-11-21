-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 20, 2025 at 02:22 PM
-- Server version: 8.0.30
-- PHP Version: 8.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dbsma1_pangururan`
--

-- --------------------------------------------------------

--
-- Table structure for table `aset_buku`
--

CREATE TABLE `aset_buku` (
  `id_aset` int NOT NULL,
  `kode_buku_induk` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `nomor_inventaris` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `status_ketersediaan` enum('Tersedia','Dipinjam','Perbaikan','Hilang') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Tersedia',
  `kondisi_fisik` enum('Baik','Rusak Ringan','Rusak Berat') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Baik',
  `lokasi_rak` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `aturan_perpustakaan`
--

CREATE TABLE `aturan_perpustakaan` (
  `nama_aturan` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `isi_aturan` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `deskripsi` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `aturan_perpustakaan`
--

INSERT INTO `aturan_perpustakaan` (`nama_aturan`, `isi_aturan`, `deskripsi`, `updated_at`) VALUES
('denda_per_hari', '500', 'Jumlah denda (Rp) per hari keterlambatan', '2025-10-16 17:45:37'),
('hari_perpanjangan', '7', 'Durasi perpanjangan (dalam hari) setelah permintaan disetujui', '2025-10-16 17:45:37'),
('maks_buku_dipinjam', '2', 'Jumlah buku maksimal yang boleh dipinjam oleh satu siswa pada waktu bersamaan', '2025-10-16 17:45:37'),
('maks_lama_pinjam', '7', 'Jumlah hari maksimal seorang siswa boleh meminjam buku', '2025-10-16 17:45:37'),
('maks_perpanjangan', '1', 'Berapa kali siswa boleh memperpanjang peminjaman untuk satu buku yang sama', '2025-10-16 17:45:37'),
('nama_perpustakaan', 'Perpustakaan Digital SMA N 1 Pangururan', 'Nama ini akan muncul di header website dan di kop surat laporan', '2025-10-16 17:45:37');

-- --------------------------------------------------------

--
-- Table structure for table `buku`
--

CREATE TABLE `buku` (
  `kode_buku` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `judul` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `nama_pengarang` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `penerbit` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tahun_terbit` int DEFAULT NULL,
  `jumlah_halaman` int DEFAULT NULL,
  `gambar` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `buku`
--

INSERT INTO `buku` (`kode_buku`, `judul`, `nama_pengarang`, `penerbit`, `tahun_terbit`, `jumlah_halaman`, `gambar`, `created_at`, `updated_at`) VALUES
('212', 'kisah cinta anak ti ', 'tungkai', 'usu', 2025, 122, '', '2025-10-16 18:17:49', '2025-10-16 18:17:49');

-- --------------------------------------------------------

--
-- Table structure for table `buku_genre`
--

CREATE TABLE `buku_genre` (
  `kode_buku` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `id_genre` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel-cache-pengunjung:2025-11-19', 'i:1;', 1763748351),
('laravel-cache-pengunjung:2025-11-20', 'i:1;', 1763778429);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `genre`
--

CREATE TABLE `genre` (
  `id_genre` int NOT NULL,
  `nama_genre` varchar(50) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `log_aktivitas`
--

CREATE TABLE `log_aktivitas` (
  `id_log` int NOT NULL,
  `id_user` int NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `nama_tabel` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `operasi` enum('insert','update','delete') COLLATE utf8mb4_general_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_general_ci,
  `id_terkait` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `data_lama` text COLLATE utf8mb4_general_ci,
  `data_baru` text COLLATE utf8mb4_general_ci,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_11_19_000000_add_nip_role_to_users', 2);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `peminjaman`
--

CREATE TABLE `peminjaman` (
  `id_peminjaman` int NOT NULL,
  `id_aset_buku` int NOT NULL,
  `nomor_identitas` varchar(30) COLLATE utf8mb4_general_ci NOT NULL,
  `tanggal_pinjam` date NOT NULL,
  `tanggal_jatuh_tempo` date NOT NULL,
  `tanggal_kembali` date DEFAULT NULL,
  `denda` int NOT NULL DEFAULT '0',
  `status_peminjaman` enum('Dipinjam','Dikembalikan','Terlambat') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Dipinjam',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pengunjung`
--

CREATE TABLE `pengunjung` (
  `nomor_identitas` varchar(30) COLLATE utf8mb4_general_ci NOT NULL,
  `nama` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `tipe_anggota` enum('Siswa','Guru','Kepala Sekolah','Staf','Umum') COLLATE utf8mb4_general_ci NOT NULL,
  `kelas` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status_keanggotaan` enum('Aktif','Tidak Aktif','Dibekukan') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Aktif',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `id_user` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pengunjung`
--

INSERT INTO `pengunjung` (`nomor_identitas`, `nama`, `tipe_anggota`, `kelas`, `status_keanggotaan`, `created_at`, `updated_at`, `id_user`) VALUES
('11223344', 'Budi Santoso', 'Siswa', 'X-A1', 'Aktif', '2025-11-09 13:18:01', '2025-11-09 13:18:01', 1),
('123456', 'Siswa Coba', 'Siswa', 'X-A1', 'Aktif', '2025-11-09 13:27:25', '2025-11-09 13:27:25', 2);

-- --------------------------------------------------------

--
-- Table structure for table `request_perpanjangan`
--

CREATE TABLE `request_perpanjangan` (
  `id_request` int NOT NULL,
  `id_peminjaman` int NOT NULL,
  `tanggal_request` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tanggal_perpanjangan_baru` date NOT NULL,
  `alasan_siswa` text COLLATE utf8mb4_general_ci,
  `status_request` enum('Diajukan','Disetujui','Ditolak') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Diajukan',
  `diproses_oleh_admin` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tanggal_diproses` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('60GoBPfwtno48VcCGevnsw4TIxtP88i0ttKxi21r', 6, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiSzhEQmM4NWFZOUVrWG1yZTNzTnVTaVoxWWFGNnJralV3VEU3Y1FOYiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7czo1OiJyb3V0ZSI7czo1OiJsb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjY7fQ==', 1763605971),
('8DX4ccGlodbpeOWiNyaT246mpnM5ewWMukhQ6ngg', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiMkhZWXdFbDd3Rkcyd2JvTmh2RWpsWk50YWlHWW91WjVDdndhSVlHNSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7czo1OiJyb3V0ZSI7czo1OiJsb2dpbiI7fX0=', 1763648341),
('BXzjuCOhtJxhq3Ag0I0pQMH6BBCICrWjF503qIDp', 6, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiazlrMlZBYnZnVUFvd2NhekRUeTVhamFvamNZWnVlQXQ0YWRQMzNERCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9wZW5ndW5qdW5nL2hhcmktaW5pIjtzOjU6InJvdXRlIjtOO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTo2O30=', 1763575757);

-- --------------------------------------------------------

--
-- Table structure for table `ulasan_buku`
--

CREATE TABLE `ulasan_buku` (
  `id_ulasan` int NOT NULL,
  `kode_buku` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `nomor_identitas` varchar(30) COLLATE utf8mb4_general_ci NOT NULL,
  `rating` tinyint(1) NOT NULL,
  `komentar` text COLLATE utf8mb4_general_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(500) COLLATE utf8mb4_general_ci NOT NULL,
  `nama` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `role` enum('admin','petugas','pengunjung','non aktif') COLLATE utf8mb4_general_ci NOT NULL,
  `foto_profil` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `username`, `password`, `nama`, `role`, `foto_profil`, `created_at`, `updated_at`) VALUES
(1, '11223344', '$2y$10$...(hash_password_disini)...', 'Budi Santoso', 'admin', NULL, '2025-11-09 13:18:01', '2025-11-16 14:49:22'),
(2, '123456', '$2y$12$1A71DVIn/8YE71gEWX96sORHz/JhNOvls5R5jDcFCtptGpquy4otG', 'Siswa Coba', 'pengunjung', NULL, '2025-11-09 13:27:25', '2025-11-10 06:59:01'),
(3, '654321', '$2y$12$1A71DVIn/8YE71gEWX96sORHz/JhNOvls5R5jDcFCtptGpquy4otG', 'Siti Nurhaliza', 'petugas', NULL, '2025-11-16 14:48:20', '2025-11-16 14:48:20'),
(4, '12345678', '$2y$12$pK0jPVVNMUssH9TbYe3.Fuy9ozv6TuVeL4/3CzuB3ooGLy8ItTwne', 'Jordan Horee', 'admin', NULL, '2025-11-19 09:47:56', '2025-11-19 09:47:56'),
(5, '87654321', '$2y$12$anKLyXknIvyUc/4KaWpa.OHaovjPY8ao7fyFo6VJWpPOmtHjgZ6PG', 'Hizkia Bujeng', 'petugas', NULL, '2025-11-19 10:03:10', '2025-11-19 10:03:10'),
(6, '09876543', '$2y$12$Zn2Oizf2xC00wrpyQTFjIe.OfvInWu.dH7WimJIaINfgpvuMHieiu', 'Holy Nathuks', 'pengunjung', NULL, '2025-11-19 10:03:52', '2025-11-19 10:03:52'),
(7, '123456789', '$2y$12$8ALYITcm5rtjGjoNPBEkn.Lt1S/2Gab91OnUTrWnqlaNTcn1v61qm', 'Jordhansks', 'admin', NULL, '2025-11-20 07:19:00', '2025-11-20 07:19:00');

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_aset_lengkap`
-- (See below for the actual view)
--
CREATE TABLE `view_aset_lengkap` (
`id_aset` int
,`judul` varchar(255)
,`kondisi_fisik` enum('Baik','Rusak Ringan','Rusak Berat')
,`lokasi_rak` varchar(50)
,`nama_pengarang` varchar(100)
,`nomor_inventaris` varchar(50)
,`status_ketersediaan` enum('Tersedia','Dipinjam','Perbaikan','Hilang')
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_buku_populer`
-- (See below for the actual view)
--
CREATE TABLE `view_buku_populer` (
`judul` varchar(255)
,`jumlah_dipinjam` bigint
,`kode_buku` varchar(20)
,`nama_pengarang` varchar(100)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_detail_peminjaman`
-- (See below for the actual view)
--
CREATE TABLE `view_detail_peminjaman` (
`denda` int
,`id_peminjaman` int
,`judul_buku` varchar(255)
,`kelas` varchar(20)
,`nama_pengarang` varchar(100)
,`nama_pengunjung` varchar(100)
,`nomor_identitas` varchar(30)
,`nomor_inventaris` varchar(50)
,`role_pengunjung` enum('Siswa','Guru','Kepala Sekolah','Staf','Umum')
,`status_peminjaman` enum('Dipinjam','Dikembalikan','Terlambat')
,`tanggal_jatuh_tempo` date
,`tanggal_kembali` date
,`tanggal_pinjam` date
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_detail_ulasan`
-- (See below for the actual view)
--
CREATE TABLE `view_detail_ulasan` (
`id_ulasan` int
,`judul_buku` varchar(255)
,`kode_buku` varchar(20)
,`komentar` text
,`nama_pengunjung` varchar(100)
,`rating` tinyint(1)
,`tanggal_ulasan` timestamp
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_katalog_buku`
-- (See below for the actual view)
--
CREATE TABLE `view_katalog_buku` (
`gambar` varchar(255)
,`genre` text
,`judul` varchar(255)
,`kode_buku` varchar(20)
,`nama_pengarang` varchar(100)
,`penerbit` varchar(100)
,`stok_tersedia` bigint
,`tahun_terbit` int
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_laporan_denda`
-- (See below for the actual view)
--
CREATE TABLE `view_laporan_denda` (
`denda` int
,`id_peminjaman` int
,`judul_buku` varchar(255)
,`nama_pengunjung` varchar(100)
,`nomor_identitas` varchar(30)
,`tanggal_jatuh_tempo` date
,`tanggal_kembali` date
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_peminjaman_buku`
-- (See below for the actual view)
--
CREATE TABLE `view_peminjaman_buku` (
`denda` int
,`gambar_buku` varchar(255)
,`id_aset_buku` int
,`id_peminjaman` int
,`judul_buku` varchar(255)
,`kelas_peminjam` varchar(20)
,`nama_peminjam` varchar(100)
,`nomor_identitas` varchar(30)
,`nomor_inventaris` varchar(50)
,`role_peminjam` enum('Siswa','Guru','Kepala Sekolah','Staf','Umum')
,`status_peminjaman` enum('Dipinjam','Dikembalikan','Terlambat')
,`tanggal_jatuh_tempo` date
,`tanggal_kembali` date
,`tanggal_pinjam` date
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_peminjaman_terlambat`
-- (See below for the actual view)
--
CREATE TABLE `view_peminjaman_terlambat` (
`denda` int
,`gambar_buku` varchar(255)
,`id_aset_buku` int
,`id_peminjaman` int
,`judul_buku` varchar(255)
,`kelas_peminjam` varchar(20)
,`nama_peminjam` varchar(100)
,`nomor_identitas` varchar(30)
,`nomor_inventaris` varchar(50)
,`role_peminjam` enum('Siswa','Guru','Kepala Sekolah','Staf','Umum')
,`status_peminjaman` enum('Dipinjam','Dikembalikan','Terlambat')
,`tanggal_jatuh_tempo` date
,`tanggal_kembali` date
,`tanggal_pinjam` date
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_profil_peminjam`
-- (See below for the actual view)
--
CREATE TABLE `view_profil_peminjam` (
`jumlah_sedang_dipinjam` bigint
,`kelas` varchar(20)
,`nama` varchar(100)
,`nomor_identitas` varchar(30)
,`role` enum('Siswa','Guru','Kepala Sekolah','Staf','Umum')
,`status_keanggotaan` enum('Aktif','Tidak Aktif','Dibekukan')
,`total_denda_tercatat` decimal(32,0)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_request_perpanjangan`
-- (See below for the actual view)
--
CREATE TABLE `view_request_perpanjangan` (
`alasan` text
,`id_peminjaman` int
,`id_request` int
,`jatuh_tempo_lama` date
,`judul_buku` varchar(255)
,`nama_pengunjung` varchar(100)
,`nomor_inventaris` varchar(50)
,`status_request` enum('Diajukan','Disetujui','Ditolak')
,`tanggal_perpanjangan_baru` date
,`tanggal_request` timestamp
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_statistik_global`
-- (See below for the actual view)
--
CREATE TABLE `view_statistik_global` (
`total_anggota_aktif` bigint
,`total_aset_fisik` bigint
,`total_buku_dipinjam` bigint
,`total_judul_buku` bigint
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_statistik_pengunjung`
-- (See below for the actual view)
--
CREATE TABLE `view_statistik_pengunjung` (
`jumlah_aktif` decimal(23,0)
,`jumlah_anggota` bigint
,`jumlah_dibekukan` decimal(23,0)
,`role` enum('Siswa','Guru','Kepala Sekolah','Staf','Umum')
);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `aset_buku`
--
ALTER TABLE `aset_buku`
  ADD PRIMARY KEY (`id_aset`),
  ADD UNIQUE KEY `nomor_inventaris` (`nomor_inventaris`),
  ADD KEY `kode_buku_induk` (`kode_buku_induk`);

--
-- Indexes for table `aturan_perpustakaan`
--
ALTER TABLE `aturan_perpustakaan`
  ADD PRIMARY KEY (`nama_aturan`);

--
-- Indexes for table `buku`
--
ALTER TABLE `buku`
  ADD PRIMARY KEY (`kode_buku`);

--
-- Indexes for table `buku_genre`
--
ALTER TABLE `buku_genre`
  ADD PRIMARY KEY (`kode_buku`,`id_genre`),
  ADD KEY `id_kategori` (`id_genre`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `genre`
--
ALTER TABLE `genre`
  ADD PRIMARY KEY (`id_genre`),
  ADD UNIQUE KEY `nama_genre` (`nama_genre`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `log_aktivitas`
--
ALTER TABLE `log_aktivitas`
  ADD PRIMARY KEY (`id_log`),
  ADD KEY `idx_user` (`id_user`),
  ADD KEY `idx_tabel` (`nama_tabel`),
  ADD KEY `idx_timestamp` (`timestamp`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD PRIMARY KEY (`id_peminjaman`),
  ADD KEY `id_aset_buku` (`id_aset_buku`),
  ADD KEY `nis_siswa` (`nomor_identitas`);

--
-- Indexes for table `pengunjung`
--
ALTER TABLE `pengunjung`
  ADD PRIMARY KEY (`nomor_identitas`),
  ADD UNIQUE KEY `id_user_unique` (`id_user`);

--
-- Indexes for table `request_perpanjangan`
--
ALTER TABLE `request_perpanjangan`
  ADD PRIMARY KEY (`id_request`),
  ADD KEY `id_peminjaman` (`id_peminjaman`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `ulasan_buku`
--
ALTER TABLE `ulasan_buku`
  ADD PRIMARY KEY (`id_ulasan`),
  ADD KEY `kode_buku` (`kode_buku`),
  ADD KEY `fk_ulasan_ke_pengunjung` (`nomor_identitas`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `aset_buku`
--
ALTER TABLE `aset_buku`
  MODIFY `id_aset` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `genre`
--
ALTER TABLE `genre`
  MODIFY `id_genre` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `log_aktivitas`
--
ALTER TABLE `log_aktivitas`
  MODIFY `id_log` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `peminjaman`
--
ALTER TABLE `peminjaman`
  MODIFY `id_peminjaman` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `request_perpanjangan`
--
ALTER TABLE `request_perpanjangan`
  MODIFY `id_request` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ulasan_buku`
--
ALTER TABLE `ulasan_buku`
  MODIFY `id_ulasan` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

-- --------------------------------------------------------

--
-- Structure for view `view_aset_lengkap`
--
DROP TABLE IF EXISTS `view_aset_lengkap`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_aset_lengkap`  AS SELECT `a`.`id_aset` AS `id_aset`, `a`.`nomor_inventaris` AS `nomor_inventaris`, `b`.`judul` AS `judul`, `b`.`nama_pengarang` AS `nama_pengarang`, `a`.`status_ketersediaan` AS `status_ketersediaan`, `a`.`kondisi_fisik` AS `kondisi_fisik`, `a`.`lokasi_rak` AS `lokasi_rak` FROM (`aset_buku` `a` join `buku` `b` on((`a`.`kode_buku_induk` = `b`.`kode_buku`))) ;

-- --------------------------------------------------------

--
-- Structure for view `view_buku_populer`
--
DROP TABLE IF EXISTS `view_buku_populer`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_buku_populer`  AS SELECT `b`.`kode_buku` AS `kode_buku`, `b`.`judul` AS `judul`, `b`.`nama_pengarang` AS `nama_pengarang`, count(`p`.`id_peminjaman`) AS `jumlah_dipinjam` FROM ((`peminjaman` `p` join `aset_buku` `a` on((`p`.`id_aset_buku` = `a`.`id_aset`))) join `buku` `b` on((`a`.`kode_buku_induk` = `b`.`kode_buku`))) GROUP BY `b`.`kode_buku` ORDER BY count(`p`.`id_peminjaman`) DESC ;

-- --------------------------------------------------------

--
-- Structure for view `view_detail_peminjaman`
--
DROP TABLE IF EXISTS `view_detail_peminjaman`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_detail_peminjaman`  AS SELECT `p`.`id_peminjaman` AS `id_peminjaman`, `p`.`tanggal_pinjam` AS `tanggal_pinjam`, `p`.`tanggal_jatuh_tempo` AS `tanggal_jatuh_tempo`, `p`.`tanggal_kembali` AS `tanggal_kembali`, `p`.`status_peminjaman` AS `status_peminjaman`, `p`.`denda` AS `denda`, `pj`.`nomor_identitas` AS `nomor_identitas`, `pj`.`nama` AS `nama_pengunjung`, `pj`.`kelas` AS `kelas`, `pj`.`tipe_anggota` AS `role_pengunjung`, `b`.`judul` AS `judul_buku`, `b`.`nama_pengarang` AS `nama_pengarang`, `a`.`nomor_inventaris` AS `nomor_inventaris` FROM (((`peminjaman` `p` join `pengunjung` `pj` on((`p`.`nomor_identitas` = `pj`.`nomor_identitas`))) join `aset_buku` `a` on((`p`.`id_aset_buku` = `a`.`id_aset`))) join `buku` `b` on((`a`.`kode_buku_induk` = `b`.`kode_buku`))) ;

-- --------------------------------------------------------

--
-- Structure for view `view_detail_ulasan`
--
DROP TABLE IF EXISTS `view_detail_ulasan`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_detail_ulasan`  AS SELECT `u`.`id_ulasan` AS `id_ulasan`, `u`.`rating` AS `rating`, `u`.`komentar` AS `komentar`, `u`.`created_at` AS `tanggal_ulasan`, `b`.`kode_buku` AS `kode_buku`, `b`.`judul` AS `judul_buku`, `pj`.`nama` AS `nama_pengunjung` FROM ((`ulasan_buku` `u` join `buku` `b` on((`u`.`kode_buku` = `b`.`kode_buku`))) join `pengunjung` `pj` on((`u`.`nomor_identitas` = `pj`.`nomor_identitas`))) ;

-- --------------------------------------------------------

--
-- Structure for view `view_katalog_buku`
--
DROP TABLE IF EXISTS `view_katalog_buku`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_katalog_buku`  AS SELECT `b`.`kode_buku` AS `kode_buku`, `b`.`judul` AS `judul`, `b`.`nama_pengarang` AS `nama_pengarang`, `b`.`penerbit` AS `penerbit`, `b`.`tahun_terbit` AS `tahun_terbit`, `b`.`gambar` AS `gambar`, (select count(0) from `aset_buku` where ((`aset_buku`.`kode_buku_induk` = `b`.`kode_buku`) and (`aset_buku`.`status_ketersediaan` = 'Tersedia'))) AS `stok_tersedia`, group_concat(`g`.`nama_genre` separator ', ') AS `genre` FROM ((`buku` `b` left join `buku_genre` `bg` on((`b`.`kode_buku` = `bg`.`kode_buku`))) left join `genre` `g` on((`bg`.`id_genre` = `g`.`id_genre`))) GROUP BY `b`.`kode_buku` ;

-- --------------------------------------------------------

--
-- Structure for view `view_laporan_denda`
--
DROP TABLE IF EXISTS `view_laporan_denda`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_laporan_denda`  AS SELECT `p`.`id_peminjaman` AS `id_peminjaman`, `pj`.`nomor_identitas` AS `nomor_identitas`, `pj`.`nama` AS `nama_pengunjung`, `b`.`judul` AS `judul_buku`, `p`.`tanggal_jatuh_tempo` AS `tanggal_jatuh_tempo`, `p`.`tanggal_kembali` AS `tanggal_kembali`, `p`.`denda` AS `denda` FROM (((`peminjaman` `p` join `pengunjung` `pj` on((`p`.`nomor_identitas` = `pj`.`nomor_identitas`))) join `aset_buku` `a` on((`p`.`id_aset_buku` = `a`.`id_aset`))) join `buku` `b` on((`a`.`kode_buku_induk` = `b`.`kode_buku`))) WHERE (`p`.`denda` > 0) ;

-- --------------------------------------------------------

--
-- Structure for view `view_peminjaman_buku`
--
DROP TABLE IF EXISTS `view_peminjaman_buku`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_peminjaman_buku`  AS SELECT `p`.`id_peminjaman` AS `id_peminjaman`, `p`.`nomor_identitas` AS `nomor_identitas`, `pj`.`nama` AS `nama_peminjam`, `pj`.`tipe_anggota` AS `role_peminjam`, `pj`.`kelas` AS `kelas_peminjam`, `p`.`id_aset_buku` AS `id_aset_buku`, `a`.`nomor_inventaris` AS `nomor_inventaris`, `b`.`judul` AS `judul_buku`, `b`.`gambar` AS `gambar_buku`, `p`.`tanggal_pinjam` AS `tanggal_pinjam`, `p`.`tanggal_jatuh_tempo` AS `tanggal_jatuh_tempo`, `p`.`tanggal_kembali` AS `tanggal_kembali`, `p`.`status_peminjaman` AS `status_peminjaman`, `p`.`denda` AS `denda` FROM (((`peminjaman` `p` join `pengunjung` `pj` on((`p`.`nomor_identitas` = `pj`.`nomor_identitas`))) join `aset_buku` `a` on((`p`.`id_aset_buku` = `a`.`id_aset`))) join `buku` `b` on((`a`.`kode_buku_induk` = `b`.`kode_buku`))) ;

-- --------------------------------------------------------

--
-- Structure for view `view_peminjaman_terlambat`
--
DROP TABLE IF EXISTS `view_peminjaman_terlambat`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_peminjaman_terlambat`  AS SELECT `view_peminjaman_buku`.`id_peminjaman` AS `id_peminjaman`, `view_peminjaman_buku`.`nomor_identitas` AS `nomor_identitas`, `view_peminjaman_buku`.`nama_peminjam` AS `nama_peminjam`, `view_peminjaman_buku`.`role_peminjam` AS `role_peminjam`, `view_peminjaman_buku`.`kelas_peminjam` AS `kelas_peminjam`, `view_peminjaman_buku`.`id_aset_buku` AS `id_aset_buku`, `view_peminjaman_buku`.`nomor_inventaris` AS `nomor_inventaris`, `view_peminjaman_buku`.`judul_buku` AS `judul_buku`, `view_peminjaman_buku`.`gambar_buku` AS `gambar_buku`, `view_peminjaman_buku`.`tanggal_pinjam` AS `tanggal_pinjam`, `view_peminjaman_buku`.`tanggal_jatuh_tempo` AS `tanggal_jatuh_tempo`, `view_peminjaman_buku`.`tanggal_kembali` AS `tanggal_kembali`, `view_peminjaman_buku`.`status_peminjaman` AS `status_peminjaman`, `view_peminjaman_buku`.`denda` AS `denda` FROM `view_peminjaman_buku` WHERE ((`view_peminjaman_buku`.`status_peminjaman` = 'Dipinjam') AND (`view_peminjaman_buku`.`tanggal_jatuh_tempo` < curdate())) ;

-- --------------------------------------------------------

--
-- Structure for view `view_profil_peminjam`
--
DROP TABLE IF EXISTS `view_profil_peminjam`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_profil_peminjam`  AS SELECT `pj`.`nomor_identitas` AS `nomor_identitas`, `pj`.`nama` AS `nama`, `pj`.`tipe_anggota` AS `role`, `pj`.`kelas` AS `kelas`, `pj`.`status_keanggotaan` AS `status_keanggotaan`, (select count(0) from `peminjaman` `p` where ((`p`.`nomor_identitas` = `pj`.`nomor_identitas`) and (`p`.`status_peminjaman` = 'Dipinjam'))) AS `jumlah_sedang_dipinjam`, (select sum(`p2`.`denda`) from `peminjaman` `p2` where ((`p2`.`nomor_identitas` = `pj`.`nomor_identitas`) and (`p2`.`denda` > 0))) AS `total_denda_tercatat` FROM `pengunjung` AS `pj` ;

-- --------------------------------------------------------

--
-- Structure for view `view_request_perpanjangan`
--
DROP TABLE IF EXISTS `view_request_perpanjangan`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_request_perpanjangan`  AS SELECT `r`.`id_request` AS `id_request`, `r`.`id_peminjaman` AS `id_peminjaman`, `r`.`tanggal_request` AS `tanggal_request`, `r`.`tanggal_perpanjangan_baru` AS `tanggal_perpanjangan_baru`, `r`.`alasan_siswa` AS `alasan`, `r`.`status_request` AS `status_request`, `p`.`tanggal_jatuh_tempo` AS `jatuh_tempo_lama`, `pj`.`nama` AS `nama_pengunjung`, `b`.`judul` AS `judul_buku`, `a`.`nomor_inventaris` AS `nomor_inventaris` FROM ((((`request_perpanjangan` `r` join `peminjaman` `p` on((`r`.`id_peminjaman` = `p`.`id_peminjaman`))) join `pengunjung` `pj` on((`p`.`nomor_identitas` = `pj`.`nomor_identitas`))) join `aset_buku` `a` on((`p`.`id_aset_buku` = `a`.`id_aset`))) join `buku` `b` on((`a`.`kode_buku_induk` = `b`.`kode_buku`))) ;

-- --------------------------------------------------------

--
-- Structure for view `view_statistik_global`
--
DROP TABLE IF EXISTS `view_statistik_global`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_statistik_global`  AS SELECT (select count(0) from `buku`) AS `total_judul_buku`, (select count(0) from `aset_buku`) AS `total_aset_fisik`, (select count(0) from `pengunjung` where (`pengunjung`.`status_keanggotaan` = 'Aktif')) AS `total_anggota_aktif`, (select count(0) from `peminjaman` where (`peminjaman`.`status_peminjaman` = 'Dipinjam')) AS `total_buku_dipinjam` ;

-- --------------------------------------------------------

--
-- Structure for view `view_statistik_pengunjung`
--
DROP TABLE IF EXISTS `view_statistik_pengunjung`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_statistik_pengunjung`  AS SELECT `pengunjung`.`tipe_anggota` AS `role`, count(0) AS `jumlah_anggota`, sum((case when (`pengunjung`.`status_keanggotaan` = 'Aktif') then 1 else 0 end)) AS `jumlah_aktif`, sum((case when (`pengunjung`.`status_keanggotaan` = 'Dibekukan') then 1 else 0 end)) AS `jumlah_dibekukan` FROM `pengunjung` GROUP BY `pengunjung`.`tipe_anggota` ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `aset_buku`
--
ALTER TABLE `aset_buku`
  ADD CONSTRAINT `fk_aset_buku_ke_buku` FOREIGN KEY (`kode_buku_induk`) REFERENCES `buku` (`kode_buku`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `buku_genre`
--
ALTER TABLE `buku_genre`
  ADD CONSTRAINT `fk_bukugenre_ke_buku` FOREIGN KEY (`kode_buku`) REFERENCES `buku` (`kode_buku`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_bukugenre_ke_genre` FOREIGN KEY (`id_genre`) REFERENCES `genre` (`id_genre`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `log_aktivitas`
--
ALTER TABLE `log_aktivitas`
  ADD CONSTRAINT `log_aktivitas_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`);

--
-- Constraints for table `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD CONSTRAINT `fk_peminjaman_ke_aset` FOREIGN KEY (`id_aset_buku`) REFERENCES `aset_buku` (`id_aset`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_peminjaman_ke_pengunjung` FOREIGN KEY (`nomor_identitas`) REFERENCES `pengunjung` (`nomor_identitas`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pengunjung`
--
ALTER TABLE `pengunjung`
  ADD CONSTRAINT `fk_pengunjung_ke_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `request_perpanjangan`
--
ALTER TABLE `request_perpanjangan`
  ADD CONSTRAINT `request_perpanjangan_ibfk_1` FOREIGN KEY (`id_peminjaman`) REFERENCES `peminjaman` (`id_peminjaman`) ON DELETE CASCADE;

--
-- Constraints for table `ulasan_buku`
--
ALTER TABLE `ulasan_buku`
  ADD CONSTRAINT `fk_ulasan_ke_pengunjung` FOREIGN KEY (`nomor_identitas`) REFERENCES `pengunjung` (`nomor_identitas`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ulasan_buku_ibfk_1` FOREIGN KEY (`kode_buku`) REFERENCES `buku` (`kode_buku`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
