<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // IMPORTANT: This migration matches the ACTUAL database schema from dbsma1_pangururan.sql
        // DO NOT run migrate:fresh as it will destroy existing data!
        Schema::create('users', function (Blueprint $table) {
            $table->integer('id_user')->autoIncrement(); // NOT id() - database uses id_user
            $table->string('username', 50)->unique();     // NOT email
            $table->string('password');
            $table->string('nama', 100);                  // NOT name
            $table->enum('role', ['admin', 'petugas', 'pengunjung', 'non aktif']);
            $table->string('foto_profil')->nullable();    // NOT foto_profil
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
