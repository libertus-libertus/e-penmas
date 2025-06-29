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
        Schema::create('registrations', function (Blueprint $table) {
            $table->id(); // Primary Key
            // Foreign Key ke patient_details (onDelete cascade)
            $table->foreignId('patient_detail_id')->constrained('patient_details')->onDelete('cascade');
            // Foreign Key ke services (onDelete cascade)
            $table->foreignId('service_id')->constrained('services')->onDelete('cascade');
            $table->date('visit_date'); // Tanggal Kunjungan
            $table->integer('queue_number'); // Nomor Antrean (disimpan sebagai integer untuk sorting/max)
            $table->enum('status', [
                'pending', 
                'confirmed', 
                'cancelled', 
                'completed'
            ])->default('pending'); // Status Pendaftaran
            $table->timestamps(); // created_at dan updated_at

            // Menambahkan unique constraint untuk kombinasi tanggal kunjungan dan nomor antrean
            $table->unique(['visit_date', 'queue_number']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registrations');
    }
};