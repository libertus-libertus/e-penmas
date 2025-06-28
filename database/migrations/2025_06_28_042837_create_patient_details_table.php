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
        Schema::create('patient_details', function (Blueprint $table) {
            $table->id();
            // Foreign Key ke tabel users
            $table->foreignId('user_id')->unique()->constrained('users')->onDelete('cascade');
            $table->string('nik')->unique();
            $table->text('address');
            $table->date('birth_date');
            $table->string('phone_number');
            $table->enum('gender', ['Laki-laki', 'Perempuan']); // Contoh enum, sesuaikan jika perlu
            $table->boolean('bpjs_status')->default(false); // Default: tidak BPJS
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_details');
    }
};