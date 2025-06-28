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
        Schema::table('users', function (Blueprint $table) {
            // Tambahkan kolom 'role' dengan default 'patient'
            $table->enum('role', ['admin', 'staff', 'patient'])->default('patient')->after('password');
            // Ubah kolom 'position' menjadi nullable
            $table->string('position')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Hapus kolom 'role'
            $table->dropColumn('role');
            $table->string('position')->nullable(false)->change(); // Mengembalikan ke not nullable
        });
    }
};