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
        Schema::create('queues', function (Blueprint $table) {
            $table->id(); // Primary Key
            // Foreign Key ke registrations (onDelete cascade)
            // Unique karena satu pendaftaran hanya punya satu antrean
            $table->foreignId('registration_id')->unique()->constrained('registrations')->onDelete('cascade');
            $table->integer('queue_number'); // Nomor Antrean (bisa sama dengan di registrations, untuk kemudahan)
            $table->enum('status', [
                'waiting', 
                'called', 
                'completed', 
                'skipped'
            ])->default('waiting'); // Status Antrean
            $table->timestamps(); // created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('queues');
    }
};