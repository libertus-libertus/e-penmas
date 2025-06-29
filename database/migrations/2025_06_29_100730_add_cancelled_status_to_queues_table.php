<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB; // WAJIB: Impor DB facade untuk menjalankan perintah SQL mentah

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Perintah SQL untuk menambahkan 'cancelled' ke daftar ENUM yang diizinkan
        // Ini akan mengubah struktur kolom 'status' di tabel 'queues'
        DB::statement("ALTER TABLE queues CHANGE status status ENUM('waiting', 'called', 'completed', 'skipped', 'cancelled') NOT NULL DEFAULT 'waiting'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Perintah SQL untuk mengembalikan kolom 'status' ke definisi ENUM sebelumnya
        // Peringatan: Jika ada data dengan status 'cancelled' yang tersimpan di tabel
        // saat migrasi ini di-rollback, data tersebut kemungkinan akan terpotong (truncated)
        // karena 'cancelled' tidak lagi menjadi nilai yang valid.
        DB::statement("ALTER TABLE queues CHANGE status status ENUM('waiting', 'called', 'completed', 'skipped') NOT NULL DEFAULT 'waiting'");
    }
};
