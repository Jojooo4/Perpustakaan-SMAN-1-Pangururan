-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 10, 2025 at 08:34 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_perpustakaan_sma1pangururan`
--

-- --------------------------------------------------------

--
-- Table structure for table `aset_buku`
--

CREATE TABLE `aset_buku` (
  `id_aset` int(11) NOT NULL,
  `id_buku` int(11) NOT NULL,
  `nomor_inventaris` varchar(50) NOT NULL,
  `kondisi_buku` enum('Baik','Rusak Ringan','Rusak Berat') DEFAULT 'Baik',
  `catatan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `aset_buku`
--

INSERT INTO `aset_buku` (`id_aset`, `id_buku`, `nomor_inventaris`, `kondisi_buku`, `catatan`) VALUES
(1, 3, 'BK-003-001', 'Baik', 'Auto-generated from stok awal'),
(2, 3, 'BK-003-002', 'Baik', 'Auto-generated from stok awal'),
(3, 3, 'BK-003-003', 'Baik', 'Auto-generated from stok awal'),
(4, 3, 'BK-003-004', 'Baik', 'Auto-generated from stok awal'),
(5, 3, 'BK-003-005', 'Baik', 'Auto-generated from stok awal'),
(6, 3, 'BK-003-006', 'Baik', 'Auto-generated from stok awal'),
(7, 3, 'BK-003-007', 'Baik', 'Auto-generated from stok awal'),
(8, 3, 'BK-003-008', 'Baik', 'Auto-generated from stok awal');

-- --------------------------------------------------------

--
-- Table structure for table `aturan_perpustakaan`
--

CREATE TABLE `aturan_perpustakaan` (
  `nama_aturan` varchar(50) NOT NULL,
  `isi_aturan` varchar(255) NOT NULL,
  `deskripsi` varchar(255) DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
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
  `id_buku` int(11) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `nama_pengarang` varchar(100) DEFAULT NULL,
  `penerbit` varchar(100) DEFAULT NULL,
  `tahun_terbit` int(4) DEFAULT NULL,
  `jumlah_halaman` int(11) DEFAULT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `stok_tersedia` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `buku`
--

INSERT INTO `buku` (`id_buku`, `judul`, `nama_pengarang`, `penerbit`, `tahun_terbit`, `jumlah_halaman`, `gambar`, `stok_tersedia`, `created_at`, `updated_at`) VALUES
(1, 'BAHASA ARAB KELAS X', 'Saidul', 'asda', 1999, 123, NULL, 12, '2025-12-08 20:44:57', '2025-12-08 20:44:57'),
(2, 'asdas', 'KEMENTRIAN AGAMA', 'KEMENTRIAN AGAMA', 1988, 89, NULL, 9, '2025-12-09 09:55:05', '2025-12-09 09:55:05'),
(3, 'u', 'Saidul', 'KEMENTRIAN AGAMA', 2000, 99, NULL, 3, '2025-12-09 10:09:03', '2025-12-09 17:30:18');

-- --------------------------------------------------------

--
-- Table structure for table `buku_genre`
--

CREATE TABLE `buku_genre` (
  `id_buku` int(11) NOT NULL,
  `id_genre` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel-cache-pengunjung:2025-11-20', 'i:1;', 1763827492),
('laravel-cache-pengunjung:2025-11-21', 'i:2;', 1763915830),
('laravel-cache-pengunjung:2025-12-09', 'i:1;', 1765472212),
('laravel-cache-pengunjung:2025-12-10', 'i:1;', 1765497939);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `genre`
--

CREATE TABLE `genre` (
  `id_genre` int(11) NOT NULL,
  `nama_genre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `log_aktivitas`
--

CREATE TABLE `log_aktivitas` (
  `id_log` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `nama_tabel` varchar(100) NOT NULL,
  `operasi` enum('insert','update','delete') NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `id_terkait` varchar(50) DEFAULT NULL,
  `data_lama` text DEFAULT NULL,
  `data_baru` text DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_01_01_000000_update_users_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `peminjaman`
--

CREATE TABLE `peminjaman` (
  `id_peminjaman` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_aset_buku` int(11) NOT NULL,
  `tanggal_pinjam` date NOT NULL,
  `tanggal_kembali` date DEFAULT NULL,
  `tanggal_jatuh_tempo` date NOT NULL,
  `denda` int(11) DEFAULT 0,
  `status_peminjaman` enum('Dipinjam','Dikembalikan','Terlambat') DEFAULT 'Dipinjam'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `peminjaman`
--

INSERT INTO `peminjaman` (`id_peminjaman`, `id_user`, `id_aset_buku`, `tanggal_pinjam`, `tanggal_kembali`, `tanggal_jatuh_tempo`, `denda`, `status_peminjaman`) VALUES
(1, 1, 1, '2025-12-09', NULL, '2025-12-16', 0, 'Dipinjam'),
(2, 1, 5, '2025-12-03', NULL, '2025-12-10', 0, 'Dipinjam'),
(3, 2, 7, '2025-12-02', NULL, '2025-12-09', 0, 'Dipinjam'),
(4, 2, 6, '2025-12-01', '2025-12-09', '2025-12-08', 865, 'Terlambat'),
(5, 2, 2, '2025-12-01', NULL, '2025-12-08', 0, 'Dipinjam'),
(6, 2, 3, '2025-12-10', NULL, '2025-12-17', 0, 'Dipinjam');

-- --------------------------------------------------------

--
-- Table structure for table `request_peminjaman`
--

CREATE TABLE `request_peminjaman` (
  `id_request` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_buku` int(11) NOT NULL,
  `status` enum('pending','disetujui','ditolak') DEFAULT 'pending',
  `tanggal_request` datetime DEFAULT current_timestamp(),
  `diproses_oleh` int(11) DEFAULT NULL,
  `tanggal_diproses` datetime DEFAULT NULL,
  `catatan_admin` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `request_peminjaman`
--

INSERT INTO `request_peminjaman` (`id_request`, `id_user`, `id_buku`, `status`, `tanggal_request`, `diproses_oleh`, `tanggal_diproses`, `catatan_admin`) VALUES
(1, 2, 3, 'disetujui', '2025-12-10 00:13:47', 5, '2025-12-10 00:30:18', NULL),
(2, 2, 3, 'pending', '2025-12-10 00:13:47', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `request_perpanjangan`
--

CREATE TABLE `request_perpanjangan` (
  `id_request` int(11) NOT NULL,
  `id_peminjaman` int(11) NOT NULL,
  `tanggal_request` datetime DEFAULT current_timestamp(),
  `status` enum('pending','disetujui','ditolak') DEFAULT 'pending',
  `tanggal_perpanjangan_baru` date DEFAULT NULL,
  `diproses_oleh` int(11) DEFAULT NULL,
  `catatan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `request_perpanjangan`
--

INSERT INTO `request_perpanjangan` (`id_request`, `id_peminjaman`, `tanggal_request`, `status`, `tanggal_perpanjangan_baru`, `diproses_oleh`, `catatan`) VALUES
(1, 6, '2025-12-10 01:07:12', 'disetujui', '2025-12-24', 5, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('5vDeTES3GF1FU0p4hwxLq5cBNkGh3O3NHMi41zwe', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoianQyUjFyREhROGUySlRZU1BCVFZNTk54eGFhNWp4eFVoZndOU1ZqTSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7czo1OiJyb3V0ZSI7czo1OiJsb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1762545582),
('6sXCiTdjeIrWEFFNusQz5UcfxLM1FexH1NJsZg16', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiSU82cUFMWXpqeE9JQWZ6d21NaXc2UXc1M1lyZ29ZRTNiUGpoOFFyZyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7czo1OiJyb3V0ZSI7czo1OiJsb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1762542513),
('NQixJXJQhBIF0RqXM66v2SBi7e7zfVJp48vG07Hx', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiVXJHanhwZkF5d2dUd3dqcFpuMkNDb2ZCQXNQWTJ5d3hjTk5VWTF3QiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7czo1OiJyb3V0ZSI7czo1OiJsb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1762541463),
('v437LmSKCVpsx3hiNsuvKT7aZVH1cy2H0XV8S33Z', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiaW15dllEalcybUlNYW1jTXpaYk00V3owa3ZaeGlVaDF6dVZPVUREZSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7czo1OiJyb3V0ZSI7czo1OiJsb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1762552544);

-- --------------------------------------------------------

--
-- Table structure for table `ulasan_buku`
--

CREATE TABLE `ulasan_buku` (
  `id_ulasan` int(11) NOT NULL,
  `id_buku` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `rating` int(1) DEFAULT NULL CHECK (`rating` between 1 and 5),
  `komentar` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `tipe_anggota` enum('Siswa','Guru','Kepala Sekolah','Staf','Umum') DEFAULT NULL,
  `kelas` varchar(20) DEFAULT NULL,
  `status_keanggotaan` enum('Aktif','Tidak Aktif','Dibekukan') DEFAULT 'Aktif',
  `role` enum('admin','petugas','pengunjung','non aktif') NOT NULL,
  `foto_profil` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `username`, `password`, `nama`, `tipe_anggota`, `kelas`, `status_keanggotaan`, `role`, `foto_profil`, `created_at`, `updated_at`) VALUES
(1, '11223344', '$2y$10$...(hash_password_disini)...', 'Budi Santoso', 'Siswa', 'X-A1', 'Aktif', 'pengunjung', NULL, '2025-11-09 13:18:01', '2025-12-05 17:04:30'),
(2, '123456', '$2y$12$8bhDhA1j3ImXcNlipJinZeGXVs6vp5bdQSGQVRLb5I9DJlffjp5j2', 'Siswa Coba', 'Siswa', 'X-A1', 'Aktif', 'pengunjung', NULL, '2025-11-09 13:27:25', '2025-12-05 17:04:30'),
(3, '12345', '$2y$12$7bDQTJxQGSV.b.NLH.ntbeXK69zPREwhN/5gqC/0KegZzsK8OdnD2', 'kia', NULL, NULL, 'Aktif', 'petugas', NULL, '2025-11-20 09:00:11', '2025-11-20 16:04:33'),
(4, '123', '$2y$12$uL.NtrCZk1bgJDbTmREWv.oBCc/RZZsp3vT38.DrmjzKxNGEcy/Zy', 'kai', NULL, NULL, 'Aktif', 'admin', NULL, '2025-11-20 09:01:43', '2025-11-20 09:01:43'),
(5, '122', '$2y$12$ge0bBY3wdqTokKNobgrvquHlrh6sKgMhJ.mT6G28EmxRl/C0lSTja', 'Administrator', NULL, NULL, 'Aktif', 'admin', NULL, '2025-12-07 09:07:34', '2025-12-07 09:08:12'),
(6, '1', '$2y$12$ge0bBY3wdqTokKNobgrvquHlrh6sKgMhJ.mT6G28EmxRl/C0lSTja', 'Petugas Perpustakaan', NULL, NULL, 'Aktif', 'petugas', NULL, '2025-12-07 09:07:35', '2025-12-07 09:08:19'),
(7, 'petugas2', '$2y$12$ge0bBY3wdqTokKNobgrvquHlrh6sKgMhJ.mT6G28EmxRl/C0lSTja', 'Petugas Perpustakaan 2', NULL, NULL, 'Aktif', 'petugas', NULL, '2025-12-07 09:07:35', '2025-12-07 09:07:35'),
(8, '12', '$2y$12$7BjLZzhlnNr/M1bxNeBbNe4JtZaRAoRduG0v3DHvZmMit0kPN/ZVy', '12123', 'Siswa', 'IX', 'Aktif', 'admin', NULL, '2025-12-08 20:48:19', '2025-12-08 20:48:19');

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_aset_lengkap`
-- (See below for the actual view)
--
CREATE TABLE `view_aset_lengkap` (
`id_aset` int(11)
,`nomor_inventaris` varchar(50)
,`id_buku` int(11)
,`judul` varchar(255)
,`nama_pengarang` varchar(100)
,`kondisi_buku` enum('Baik','Rusak Ringan','Rusak Berat')
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_buku_populer`
-- (See below for the actual view)
--
CREATE TABLE `view_buku_populer` (
`id_buku` int(11)
,`judul` varchar(255)
,`nama_pengarang` varchar(100)
,`jumlah_dipinjam` bigint(21)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_detail_peminjaman`
-- (See below for the actual view)
--
CREATE TABLE `view_detail_peminjaman` (
`id_peminjaman` int(11)
,`tanggal_pinjam` date
,`tanggal_jatuh_tempo` date
,`tanggal_kembali` date
,`status_peminjaman` enum('Dipinjam','Dikembalikan','Terlambat')
,`denda` int(11)
,`id_user` int(11)
,`nama_pengunjung` varchar(100)
,`kelas` varchar(20)
,`role_pengunjung` enum('Siswa','Guru','Kepala Sekolah','Staf','Umum')
,`id_buku` int(11)
,`judul_buku` varchar(255)
,`nama_pengarang` varchar(100)
,`nomor_inventaris` varchar(50)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_detail_ulasan`
-- (See below for the actual view)
--
CREATE TABLE `view_detail_ulasan` (
`id_ulasan` int(11)
,`rating` int(1)
,`komentar` text
,`id_buku` int(11)
,`judul_buku` varchar(255)
,`nama_pengunjung` varchar(100)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_katalog_buku`
-- (See below for the actual view)
--
CREATE TABLE `view_katalog_buku` (
`id_buku` int(11)
,`judul` varchar(255)
,`nama_pengarang` varchar(100)
,`penerbit` varchar(100)
,`tahun_terbit` int(4)
,`gambar` varchar(255)
,`stok_tersedia` int(11)
,`genre` mediumtext
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_laporan_denda`
-- (See below for the actual view)
--
CREATE TABLE `view_laporan_denda` (
`id_peminjaman` int(11)
,`id_user` int(11)
,`username` varchar(50)
,`nama_pengunjung` varchar(100)
,`id_buku` int(11)
,`judul_buku` varchar(255)
,`tanggal_jatuh_tempo` date
,`tanggal_kembali` date
,`denda` int(11)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_peminjaman_buku`
-- (See below for the actual view)
--
CREATE TABLE `view_peminjaman_buku` (
`id_peminjaman` int(11)
,`id_user` int(11)
,`nama_peminjam` varchar(100)
,`role_peminjam` enum('Siswa','Guru','Kepala Sekolah','Staf','Umum')
,`kelas_peminjam` varchar(20)
,`id_aset_buku` int(11)
,`nomor_inventaris` varchar(50)
,`id_buku` int(11)
,`judul_buku` varchar(255)
,`gambar_buku` varchar(255)
,`tanggal_pinjam` date
,`tanggal_jatuh_tempo` date
,`tanggal_kembali` date
,`status_peminjaman` enum('Dipinjam','Dikembalikan','Terlambat')
,`denda` int(11)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_peminjaman_terlambat`
-- (See below for the actual view)
--
CREATE TABLE `view_peminjaman_terlambat` (
`id_peminjaman` int(11)
,`id_user` int(11)
,`nama_peminjam` varchar(100)
,`role_peminjam` enum('Siswa','Guru','Kepala Sekolah','Staf','Umum')
,`kelas_peminjam` varchar(20)
,`id_aset_buku` int(11)
,`nomor_inventaris` varchar(50)
,`id_buku` int(11)
,`judul_buku` varchar(255)
,`gambar_buku` varchar(255)
,`tanggal_pinjam` date
,`tanggal_jatuh_tempo` date
,`tanggal_kembali` date
,`status_peminjaman` enum('Dipinjam','Dikembalikan','Terlambat')
,`denda` int(11)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_profil_peminjam`
-- (See below for the actual view)
--
CREATE TABLE `view_profil_peminjam` (
`id_user` int(11)
,`username` varchar(50)
,`nama` varchar(100)
,`role` enum('Siswa','Guru','Kepala Sekolah','Staf','Umum')
,`kelas` varchar(20)
,`status_keanggotaan` enum('Aktif','Tidak Aktif','Dibekukan')
,`jumlah_sedang_dipinjam` bigint(21)
,`total_denda_tercatat` decimal(32,0)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_request_perpanjangan`
-- (See below for the actual view)
--
CREATE TABLE `view_request_perpanjangan` (
`id_request` int(11)
,`id_peminjaman` int(11)
,`tanggal_request` datetime
,`tanggal_perpanjangan_baru` date
,`alasan` text
,`status` enum('pending','disetujui','ditolak')
,`jatuh_tempo_lama` date
,`nama_pengunjung` varchar(100)
,`id_buku` int(11)
,`judul_buku` varchar(255)
,`nomor_inventaris` varchar(50)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_statistik_global`
-- (See below for the actual view)
--
CREATE TABLE `view_statistik_global` (
`total_judul_buku` bigint(21)
,`total_aset_fisik` bigint(21)
,`total_anggota_aktif` bigint(21)
,`total_buku_dipinjam` bigint(21)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_statistik_pengunjung`
-- (See below for the actual view)
--
CREATE TABLE `view_statistik_pengunjung` (
`role` enum('Siswa','Guru','Kepala Sekolah','Staf','Umum')
,`jumlah_anggota` bigint(21)
,`jumlah_aktif` decimal(22,0)
,`jumlah_dibekukan` decimal(22,0)
);

-- --------------------------------------------------------

--
-- Structure for view `view_aset_lengkap`
--
DROP TABLE IF EXISTS `view_aset_lengkap`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_aset_lengkap`  AS SELECT `a`.`id_aset` AS `id_aset`, `a`.`nomor_inventaris` AS `nomor_inventaris`, `b`.`id_buku` AS `id_buku`, `b`.`judul` AS `judul`, `b`.`nama_pengarang` AS `nama_pengarang`, `a`.`kondisi_buku` AS `kondisi_buku` FROM (`aset_buku` `a` join `buku` `b` on(`a`.`id_buku` = `b`.`id_buku`)) ;

-- --------------------------------------------------------

--
-- Structure for view `view_buku_populer`
--
DROP TABLE IF EXISTS `view_buku_populer`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_buku_populer`  AS SELECT `b`.`id_buku` AS `id_buku`, `b`.`judul` AS `judul`, `b`.`nama_pengarang` AS `nama_pengarang`, count(`p`.`id_peminjaman`) AS `jumlah_dipinjam` FROM ((`buku` `b` left join `aset_buku` `a` on(`b`.`id_buku` = `a`.`id_buku`)) left join `peminjaman` `p` on(`a`.`id_aset` = `p`.`id_aset_buku`)) GROUP BY `b`.`id_buku`, `b`.`judul`, `b`.`nama_pengarang` ORDER BY count(`p`.`id_peminjaman`) DESC ;

-- --------------------------------------------------------

--
-- Structure for view `view_detail_peminjaman`
--
DROP TABLE IF EXISTS `view_detail_peminjaman`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_detail_peminjaman`  AS SELECT `p`.`id_peminjaman` AS `id_peminjaman`, `p`.`tanggal_pinjam` AS `tanggal_pinjam`, `p`.`tanggal_jatuh_tempo` AS `tanggal_jatuh_tempo`, `p`.`tanggal_kembali` AS `tanggal_kembali`, `p`.`status_peminjaman` AS `status_peminjaman`, `p`.`denda` AS `denda`, `u`.`id_user` AS `id_user`, `u`.`nama` AS `nama_pengunjung`, `u`.`kelas` AS `kelas`, `u`.`tipe_anggota` AS `role_pengunjung`, `b`.`id_buku` AS `id_buku`, `b`.`judul` AS `judul_buku`, `b`.`nama_pengarang` AS `nama_pengarang`, `a`.`nomor_inventaris` AS `nomor_inventaris` FROM (((`peminjaman` `p` join `users` `u` on(`p`.`id_user` = `u`.`id_user`)) join `aset_buku` `a` on(`p`.`id_aset_buku` = `a`.`id_aset`)) join `buku` `b` on(`a`.`id_buku` = `b`.`id_buku`)) ;

-- --------------------------------------------------------

--
-- Structure for view `view_detail_ulasan`
--
DROP TABLE IF EXISTS `view_detail_ulasan`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_detail_ulasan`  AS SELECT `u`.`id_ulasan` AS `id_ulasan`, `u`.`rating` AS `rating`, `u`.`komentar` AS `komentar`, `b`.`id_buku` AS `id_buku`, `b`.`judul` AS `judul_buku`, `usr`.`nama` AS `nama_pengunjung` FROM ((`ulasan_buku` `u` join `buku` `b` on(`u`.`id_buku` = `b`.`id_buku`)) join `users` `usr` on(`u`.`id_user` = `usr`.`id_user`)) ;

-- --------------------------------------------------------

--
-- Structure for view `view_katalog_buku`
--
DROP TABLE IF EXISTS `view_katalog_buku`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_katalog_buku`  AS SELECT `b`.`id_buku` AS `id_buku`, `b`.`judul` AS `judul`, `b`.`nama_pengarang` AS `nama_pengarang`, `b`.`penerbit` AS `penerbit`, `b`.`tahun_terbit` AS `tahun_terbit`, `b`.`gambar` AS `gambar`, `b`.`stok_tersedia` AS `stok_tersedia`, group_concat(`g`.`nama_genre` separator ', ') AS `genre` FROM ((`buku` `b` left join `buku_genre` `bg` on(`b`.`id_buku` = `bg`.`id_buku`)) left join `genre` `g` on(`bg`.`id_genre` = `g`.`id_genre`)) GROUP BY `b`.`id_buku` ;

-- --------------------------------------------------------

--
-- Structure for view `view_laporan_denda`
--
DROP TABLE IF EXISTS `view_laporan_denda`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_laporan_denda`  AS SELECT `p`.`id_peminjaman` AS `id_peminjaman`, `u`.`id_user` AS `id_user`, `u`.`username` AS `username`, `u`.`nama` AS `nama_pengunjung`, `b`.`id_buku` AS `id_buku`, `b`.`judul` AS `judul_buku`, `p`.`tanggal_jatuh_tempo` AS `tanggal_jatuh_tempo`, `p`.`tanggal_kembali` AS `tanggal_kembali`, `p`.`denda` AS `denda` FROM (((`peminjaman` `p` join `users` `u` on(`p`.`id_user` = `u`.`id_user`)) join `aset_buku` `a` on(`p`.`id_aset_buku` = `a`.`id_aset`)) join `buku` `b` on(`a`.`id_buku` = `b`.`id_buku`)) WHERE `p`.`denda` > 0 ;

-- --------------------------------------------------------

--
-- Structure for view `view_peminjaman_buku`
--
DROP TABLE IF EXISTS `view_peminjaman_buku`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_peminjaman_buku`  AS SELECT `p`.`id_peminjaman` AS `id_peminjaman`, `p`.`id_user` AS `id_user`, `u`.`nama` AS `nama_peminjam`, `u`.`tipe_anggota` AS `role_peminjam`, `u`.`kelas` AS `kelas_peminjam`, `p`.`id_aset_buku` AS `id_aset_buku`, `a`.`nomor_inventaris` AS `nomor_inventaris`, `b`.`id_buku` AS `id_buku`, `b`.`judul` AS `judul_buku`, `b`.`gambar` AS `gambar_buku`, `p`.`tanggal_pinjam` AS `tanggal_pinjam`, `p`.`tanggal_jatuh_tempo` AS `tanggal_jatuh_tempo`, `p`.`tanggal_kembali` AS `tanggal_kembali`, `p`.`status_peminjaman` AS `status_peminjaman`, `p`.`denda` AS `denda` FROM (((`peminjaman` `p` join `users` `u` on(`p`.`id_user` = `u`.`id_user`)) join `aset_buku` `a` on(`p`.`id_aset_buku` = `a`.`id_aset`)) join `buku` `b` on(`a`.`id_buku` = `b`.`id_buku`)) ;

-- --------------------------------------------------------

--
-- Structure for view `view_peminjaman_terlambat`
--
DROP TABLE IF EXISTS `view_peminjaman_terlambat`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_peminjaman_terlambat`  AS SELECT `view_peminjaman_buku`.`id_peminjaman` AS `id_peminjaman`, `view_peminjaman_buku`.`id_user` AS `id_user`, `view_peminjaman_buku`.`nama_peminjam` AS `nama_peminjam`, `view_peminjaman_buku`.`role_peminjam` AS `role_peminjam`, `view_peminjaman_buku`.`kelas_peminjam` AS `kelas_peminjam`, `view_peminjaman_buku`.`id_aset_buku` AS `id_aset_buku`, `view_peminjaman_buku`.`nomor_inventaris` AS `nomor_inventaris`, `view_peminjaman_buku`.`id_buku` AS `id_buku`, `view_peminjaman_buku`.`judul_buku` AS `judul_buku`, `view_peminjaman_buku`.`gambar_buku` AS `gambar_buku`, `view_peminjaman_buku`.`tanggal_pinjam` AS `tanggal_pinjam`, `view_peminjaman_buku`.`tanggal_jatuh_tempo` AS `tanggal_jatuh_tempo`, `view_peminjaman_buku`.`tanggal_kembali` AS `tanggal_kembali`, `view_peminjaman_buku`.`status_peminjaman` AS `status_peminjaman`, `view_peminjaman_buku`.`denda` AS `denda` FROM `view_peminjaman_buku` WHERE `view_peminjaman_buku`.`status_peminjaman` = 'Dipinjam' AND `view_peminjaman_buku`.`tanggal_jatuh_tempo` < curdate() ;

-- --------------------------------------------------------

--
-- Structure for view `view_profil_peminjam`
--
DROP TABLE IF EXISTS `view_profil_peminjam`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_profil_peminjam`  AS SELECT `u`.`id_user` AS `id_user`, `u`.`username` AS `username`, `u`.`nama` AS `nama`, `u`.`tipe_anggota` AS `role`, `u`.`kelas` AS `kelas`, `u`.`status_keanggotaan` AS `status_keanggotaan`, (select count(0) from `peminjaman` `p` where `p`.`id_user` = `u`.`id_user` and `p`.`status_peminjaman` = 'Dipinjam') AS `jumlah_sedang_dipinjam`, (select sum(`p2`.`denda`) from `peminjaman` `p2` where `p2`.`id_user` = `u`.`id_user` and `p2`.`denda` > 0) AS `total_denda_tercatat` FROM `users` AS `u` WHERE `u`.`role` = 'pengunjung' ;

-- --------------------------------------------------------

--
-- Structure for view `view_request_perpanjangan`
--
DROP TABLE IF EXISTS `view_request_perpanjangan`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_request_perpanjangan`  AS SELECT `r`.`id_request` AS `id_request`, `r`.`id_peminjaman` AS `id_peminjaman`, `r`.`tanggal_request` AS `tanggal_request`, `r`.`tanggal_perpanjangan_baru` AS `tanggal_perpanjangan_baru`, `r`.`catatan` AS `alasan`, `r`.`status` AS `status`, `p`.`tanggal_jatuh_tempo` AS `jatuh_tempo_lama`, `u`.`nama` AS `nama_pengunjung`, `b`.`id_buku` AS `id_buku`, `b`.`judul` AS `judul_buku`, `a`.`nomor_inventaris` AS `nomor_inventaris` FROM ((((`request_perpanjangan` `r` join `peminjaman` `p` on(`r`.`id_peminjaman` = `p`.`id_peminjaman`)) join `users` `u` on(`p`.`id_user` = `u`.`id_user`)) join `aset_buku` `a` on(`p`.`id_aset_buku` = `a`.`id_aset`)) join `buku` `b` on(`a`.`id_buku` = `b`.`id_buku`)) ;

-- --------------------------------------------------------

--
-- Structure for view `view_statistik_global`
--
DROP TABLE IF EXISTS `view_statistik_global`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_statistik_global`  AS SELECT (select count(0) from `buku`) AS `total_judul_buku`, (select count(0) from `aset_buku`) AS `total_aset_fisik`, (select count(0) from `users` where `users`.`status_keanggotaan` = 'Aktif' and `users`.`role` = 'pengunjung') AS `total_anggota_aktif`, (select count(0) from `peminjaman` where `peminjaman`.`status_peminjaman` = 'Dipinjam') AS `total_buku_dipinjam` ;

-- --------------------------------------------------------

--
-- Structure for view `view_statistik_pengunjung`
--
DROP TABLE IF EXISTS `view_statistik_pengunjung`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_statistik_pengunjung`  AS SELECT `users`.`tipe_anggota` AS `role`, count(0) AS `jumlah_anggota`, sum(case when `users`.`status_keanggotaan` = 'Aktif' then 1 else 0 end) AS `jumlah_aktif`, sum(case when `users`.`status_keanggotaan` = 'Dibekukan' then 1 else 0 end) AS `jumlah_dibekukan` FROM `users` WHERE `users`.`role` = 'pengunjung' GROUP BY `users`.`tipe_anggota` ;

-- --------------------------------------------------------

--
-- Table structure for table `login_event`
--

CREATE TABLE `login_event` (
  `id_login` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `waktu_login` datetime NOT NULL DEFAULT current_timestamp(),
  `waktu_logout` datetime DEFAULT NULL,
  `sumber` varchar(50) DEFAULT 'web'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_login_hari_ini`
-- (See below for the actual view)
--
CREATE TABLE `view_login_hari_ini` (
`id_user` int(11)
,`username` varchar(50)
,`nama` varchar(100)
,`tipe_anggota` enum('Siswa','Guru','Kepala Sekolah','Staf','Umum')
,`role` enum('admin','petugas','pengunjung','non aktif')
,`waktu_terakhir_login` datetime
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_total_login_hari_ini`
-- (See below for the actual view)
--
CREATE TABLE `view_total_login_hari_ini` (
`total_login_hari_ini` bigint(21)
);

-- --------------------------------------------------------

--
-- Structure for view `view_login_hari_ini`
--
DROP TABLE IF EXISTS `view_login_hari_ini`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_login_hari_ini`  AS 
SELECT 
  u.`id_user` AS `id_user`, 
  u.`username` AS `username`, 
  u.`nama` AS `nama`, 
  u.`tipe_anggota` AS `tipe_anggota`, 
  u.`role` AS `role`, 
  MAX(le.`waktu_login`) AS `waktu_terakhir_login`
FROM `login_event` le
JOIN `users` u ON u.`id_user` = le.`id_user`
WHERE DATE(le.`waktu_login`) = CURDATE() AND u.`role` = 'pengunjung'
GROUP BY u.`id_user`, u.`username`, u.`nama`, u.`tipe_anggota`, u.`role`
ORDER BY `waktu_terakhir_login` DESC ;

-- --------------------------------------------------------

--
-- Structure for view `view_total_login_hari_ini`
--
DROP TABLE IF EXISTS `view_total_login_hari_ini`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_total_login_hari_ini`  AS 
SELECT COUNT(DISTINCT le.`id_user`) AS `total_login_hari_ini`
FROM `login_event` le
JOIN `users` u ON u.`id_user` = le.`id_user`
WHERE DATE(le.`waktu_login`) = CURDATE() AND u.`role` = 'pengunjung' ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `aset_buku`
--
ALTER TABLE `aset_buku`
  ADD PRIMARY KEY (`id_aset`),
  ADD UNIQUE KEY `nomor_inventaris` (`nomor_inventaris`),
  ADD KEY `id_buku` (`id_buku`);

--
-- Indexes for table `aturan_perpustakaan`
--
ALTER TABLE `aturan_perpustakaan`
  ADD PRIMARY KEY (`nama_aturan`);

--
-- Indexes for table `buku`
--
ALTER TABLE `buku`
  ADD PRIMARY KEY (`id_buku`);

--
-- Indexes for table `buku_genre`
--
ALTER TABLE `buku_genre`
  ADD PRIMARY KEY (`id_buku`,`id_genre`),
  ADD KEY `id_genre` (`id_genre`);

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
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_aset_buku` (`id_aset_buku`);

--
-- Indexes for table `request_peminjaman`
--
ALTER TABLE `request_peminjaman`
  ADD PRIMARY KEY (`id_request`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_buku` (`id_buku`),
  ADD KEY `diproses_oleh` (`diproses_oleh`);

--
-- Indexes for table `request_perpanjangan`
--
ALTER TABLE `request_perpanjangan`
  ADD PRIMARY KEY (`id_request`),
  ADD KEY `id_peminjaman` (`id_peminjaman`),
  ADD KEY `diproses_oleh` (`diproses_oleh`);

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
  ADD KEY `id_buku` (`id_buku`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `login_event`
--
ALTER TABLE `login_event`
  ADD PRIMARY KEY (`id_login`),
  ADD KEY `idx_login_user` (`id_user`),
  ADD KEY `idx_login_waktu` (`waktu_login`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `aset_buku`
--
ALTER TABLE `aset_buku`
  MODIFY `id_aset` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `buku`
--
ALTER TABLE `buku`
  MODIFY `id_buku` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `genre`
--
ALTER TABLE `genre`
  MODIFY `id_genre` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `log_aktivitas`
--
ALTER TABLE `log_aktivitas`
  MODIFY `id_log` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `peminjaman`
--
ALTER TABLE `peminjaman`
  MODIFY `id_peminjaman` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `request_peminjaman`
--
ALTER TABLE `request_peminjaman`
  MODIFY `id_request` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `request_perpanjangan`
--
ALTER TABLE `request_perpanjangan`
  MODIFY `id_request` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ulasan_buku`
--
ALTER TABLE `ulasan_buku`
  MODIFY `id_ulasan` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `login_event`
--
ALTER TABLE `login_event`
  MODIFY `id_login` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `aset_buku`
--
ALTER TABLE `aset_buku`
  ADD CONSTRAINT `aset_buku_ibfk_1` FOREIGN KEY (`id_buku`) REFERENCES `buku` (`id_buku`) ON DELETE CASCADE;

--
-- Constraints for table `buku_genre`
--
ALTER TABLE `buku_genre`
  ADD CONSTRAINT `buku_genre_ibfk_1` FOREIGN KEY (`id_buku`) REFERENCES `buku` (`id_buku`) ON DELETE CASCADE,
  ADD CONSTRAINT `buku_genre_ibfk_2` FOREIGN KEY (`id_genre`) REFERENCES `genre` (`id_genre`) ON DELETE CASCADE;

--
-- Constraints for table `log_aktivitas`
--
ALTER TABLE `log_aktivitas`
  ADD CONSTRAINT `log_aktivitas_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`);

--
-- Constraints for table `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD CONSTRAINT `peminjaman_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE,
  ADD CONSTRAINT `peminjaman_ibfk_2` FOREIGN KEY (`id_aset_buku`) REFERENCES `aset_buku` (`id_aset`) ON DELETE CASCADE;

--
-- Constraints for table `request_peminjaman`
--
ALTER TABLE `request_peminjaman`
  ADD CONSTRAINT `request_peminjaman_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE,
  ADD CONSTRAINT `request_peminjaman_ibfk_2` FOREIGN KEY (`id_buku`) REFERENCES `buku` (`id_buku`) ON DELETE CASCADE,
  ADD CONSTRAINT `request_peminjaman_ibfk_3` FOREIGN KEY (`diproses_oleh`) REFERENCES `users` (`id_user`) ON DELETE SET NULL;

--
-- Constraints for table `request_perpanjangan`
--
ALTER TABLE `request_perpanjangan`
  ADD CONSTRAINT `request_perpanjangan_ibfk_1` FOREIGN KEY (`id_peminjaman`) REFERENCES `peminjaman` (`id_peminjaman`) ON DELETE CASCADE,
  ADD CONSTRAINT `request_perpanjangan_ibfk_2` FOREIGN KEY (`diproses_oleh`) REFERENCES `users` (`id_user`) ON DELETE SET NULL;

--
-- Constraints for table `ulasan_buku`
--
ALTER TABLE `ulasan_buku`
  ADD CONSTRAINT `ulasan_buku_ibfk_1` FOREIGN KEY (`id_buku`) REFERENCES `buku` (`id_buku`) ON DELETE CASCADE,
  ADD CONSTRAINT `ulasan_buku_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE;

--
-- Constraints for table `login_event`
--
ALTER TABLE `login_event`
  ADD CONSTRAINT `login_event_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
