<?php

// Migration intentionally disabled. User requested not to add columns because
// `role` already exists and `nip`/`nisn` are stored in `username`. Leaving
// this file as a no-op so it won't modify the database.

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        // intentionally left blank
    }

    public function down(): void
    {
        // intentionally left blank
    }
};
