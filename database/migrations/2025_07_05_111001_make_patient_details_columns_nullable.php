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
        Schema::table('patient_details', function (Blueprint $table) {
            // Mengubah kolom menjadi nullable
            $table->string('nik')->nullable()->change();
            $table->text('address')->nullable()->change();
            $table->date('birth_date')->nullable()->change();
            $table->string('phone_number')->nullable()->change();
            $table->string('gender')->nullable()->change(); // Sesuaikan jika gender adalah ENUM
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patient_details', function (Blueprint $table) {
            // Mengembalikan kolom menjadi not nullable (hati-hati jika ada data null)
            // Anda mungkin perlu menambahkan default value atau menghapus data null sebelum rollback di produksi
            $table->string('nik')->nullable(false)->change();
            $table->text('address')->nullable(false)->change();
            $table->date('birth_date')->nullable(false)->change();
            $table->string('phone_number')->nullable(false)->change();
            $table->string('gender')->nullable(false)->change();
        });
    }
};
