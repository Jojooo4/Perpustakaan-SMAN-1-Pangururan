# Website Perpustakaan SMA Negeri 1 Pangururan

PM MEDELEINE
UI/UX-FRONT END JORDAN
FRONT END HOLY
FRONT END YARLIN 
BACK END - FRONT END - UI/UX HISKIA
BACK END - JOY

## Description
SMA Negeri 1 Pangururan adalah sebuah sekolah menengah atas yang ada di kabupaten samosir. Sistem yang berjalan di Perpustakaan SMA Negeri 1 Pangururan masih bersifat konvensional dan manual, dengan pencatatan ganda menggunakan buku peminjaman dan kartu peminjaman siswa yang disimpan di perpustakaan. Walaupun sistem ini sederhana dan mudah dijalankan, ia menimbulkan masalah efisiensi, akurasi, dan keterbatasan akses data. Oleh karena itu, dibutuhkan sistem manajemen basis data perpustakaan berbasis komputer untuk mengotomatisasi proses peminjaman, pelacakan, serta pelaporan agar lebih cepat, akurat, dan terintegrasi.

## User Requerement
Admin

Admin dapat melakukan login dengan memasukkan username dan password untuk mengakses dashboard admin.

Setelah login, Admin dapat melihat statistik penggunaan sistem yang mencakup total buku, jumlah peminjaman, laporan denda, serta jumlah anggota aktif.

Admin dapat melihat seluruh data buku yang terdaftar di perpustakaan melalui halaman Manajemen Buku.

Admin dapat melakukan pencarian buku berdasarkan judul, penulis, penerbit, tahun terbit, atau kategori melalui fitur search.

Admin dapat menambahkan data buku baru dengan mengisi informasi lengkap seperti judul, penulis, penerbit, tahun terbit, dan kategori buku melalui tombol Tambah Buku.

Admin dapat mengedit atau menghapus data buku serta menghapus eksemplar buku tertentu.

Admin dapat mengelola akun pengguna (petugas dan pengunjung), meliputi penambahan, pengeditan, dan penghapusan akun di halaman Manajemen User.

Admin dapat mencatat, mengubah, dan menghapus laporan peminjaman dan pengembalian buku dari pengunjung.

Admin dapat mengelola permintaan perpanjangan peminjaman yang diajukan oleh pengunjung.

Admin dapat mencetak laporan denda buku dengan mengekspor data ke format Excel untuk keperluan administrasi.

Admin dapat melihat review atau ulasan buku yang diberikan oleh pengunjung.

Admin dapat mencatat laporan denda untuk kasus keterlambatan pengembalian, kehilangan, atau kerusakan buku.

Admin dapat melihat dan memperbarui profil pribadi melalui halaman Pengaturan Profil Admin.

👩‍💻 Petugas

Petugas dapat login menggunakan username dan password untuk mengakses dashboard petugas.

Petugas dapat melihat seluruh data buku yang tersedia di perpustakaan.

Petugas dapat mencari buku berdasarkan judul, penulis, penerbit, tahun terbit, atau kategori melalui fitur search.

Petugas dapat menambahkan buku baru melalui tombol Tambah Buku, dengan mengisi data lengkap buku seperti judul, penulis, penerbit, tahun terbit, dan kategori.

Petugas dapat mengedit dan menghapus data buku atau eksemplar buku tertentu.

Petugas dapat mengelola akun pengunjung, termasuk menambah, mengedit, dan menghapus data pengguna di halaman Manajemen User.

Petugas dapat mencatat, menghapus, dan mengedit laporan peminjaman serta pengembalian buku.

Petugas dapat mengelola permintaan perpanjangan peminjaman dari pengunjung.

Petugas dapat melihat ulasan atau review buku dari pengunjung.

Petugas dapat mencatat laporan denda akibat keterlambatan, kehilangan, atau kerusakan buku.

Petugas dapat melihat dan memperbarui profil pribadi melalui halaman Pengaturan Profil Petugas.

📚 Pengunjung

Pengunjung dapat login menggunakan username dan password untuk mengakses dashboard pengunjung.

Pengunjung dapat melihat katalog buku lengkap dengan detail seperti ketersediaan, deskripsi, dan ulasan dari pengguna lain.

Pengunjung dapat mencari buku berdasarkan judul, penulis, penerbit, tahun terbit, atau kategori melalui fitur search.

Pengunjung dapat memberikan ulasan, rating, atau review terhadap buku yang telah dipinjam.

Pengunjung dapat melihat riwayat peminjaman buku mereka.

Pengunjung dapat mengajukan perpanjangan waktu peminjaman melalui sistem.

Pengunjung dapat melihat dan mengubah profil pribadi di halaman Profil User.

## Tech Stack

- **Composer v2.8.6** Package manager PHP (untuk membuat project laravel)
- **Laravel v12.14.1** sebagai framework PHP untuk membangun aplikasi web
- **PHP v8.4.4** sebagai bahasa pemrograman
-  **Laragon 6** sebagai server
- **MySQL v15.1** sebagai database
- **HTML, CSS, dan JavaScript** untuk membuat tampilan dan interaktivitas website

### Setup dan Run Project

Install dependensi PHP melalui Composer, pastikan Composer sudah terinstall

    composer install

Jika Composer belum diinstall : https://getcomposer.org/download/

Buat salinan file .env.example menjadi .env

    cp .env.example .env

Generate App Key

    php artisan key:generate

Atur file .env sesuai dengan konfigurasi database lokalmu

    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=nama_database
    DB_USERNAME=root
    DB_PASSWORD=

Jalankan migrasi database

    php artisan migrate

Jalankan server

    php artisan serve

