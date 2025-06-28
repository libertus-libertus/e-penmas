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
        Schema::create('service_schedules', function (Blueprint $table) {
            $table->id(); // Primary Key
            $table->foreignId('service_id')->constrained('services')->onDelete('cascade'); // Foreign Key ke tabel services
            $table->string('day'); // Hari (misal: 'Senin', 'Selasa', atau 'Monday', 'Tuesday')
            $table->time('start_time'); // Jam Mulai
            $table->time('end_time'); // Jam Selesai
            $table->timestamps(); // created_at dan updated_at

            // Menambahkan unique constraint agar satu layanan tidak punya jadwal ganda di hari yang sama
            $table->unique(['service_id', 'day']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_schedules');
    }
};