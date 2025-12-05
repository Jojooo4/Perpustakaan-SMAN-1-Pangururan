<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Create buku table
        Schema::create('buku', function (Blueprint $table) {
            $table->string('kode_buku', 20)->primary();
            $table->string('judul', 255);
            $table->string('pengarang', 100)->nullable();
            $table->string('penerbit', 100)->nullable();
            $table->integer('tahun_terbit')->nullable();
            $table->string('kategori', 50)->nullable();
            $table->integer('stok')->default(0);
            $table->text('deskripsi')->nullable();
            $table->string('gambar_sampul')->nullable();
            $table->timestamps();
        });

        // Create peminjaman table
        Schema::create('peminjaman', function (Blueprint $table) {
            $table->id('id_peminjaman');
            $table->foreignId('id_user')->constrained('users', 'id')->onDelete('cascade');
            $table->string('kode_buku', 20);
            $table->date('tanggal_pinjam');
            $table->date('tanggal_kembali')->nullable();
            $table->date('batas_kembali');
            $table->integer('perpanjangan')->default(0);
            $table->enum('status', ['dipinjam', 'dikembalikan', 'terlambat'])->default('dipinjam');
            $table->decimal('denda', 10, 2)->default(0);
            $table->boolean('denda_lunas')->default(false);
            $table->timestamps();

            $table->foreign('kode_buku')->references('kode_buku')->on('buku')->onDelete('cascade');
        });

        // Create ulasan_buku table
        Schema::create('ulasan_buku', function (Blueprint $table) {
            $table->id('id_ulasan');
            $table->string('kode_buku', 20);
            $table->foreignId('id_user')->constrained('users', 'id')->onDelete('cascade');
            $table->integer('rating');
            $table->text('komentar')->nullable();
            $table->timestamps();

            $table->foreign('kode_buku')->references('kode_buku')->on('buku')->onDelete('cascade');
        });

        // Create perpanjangan table
        Schema::create('perpanjangan', function (Blueprint $table) {
            $table->id('id_perpanjangan');
            $table->unsignedBigInteger('id_peminjaman');
            $table->date('tanggal_perpanjangan');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamps();

            $table->foreign('id_peminjaman')->references('id_peminjaman')->on('peminjaman')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('perpanjangan');
        Schema::dropIfExists('ulasan_buku');
        Schema::dropIfExists('peminjaman');
        Schema::dropIfExists('buku');
    }
};
