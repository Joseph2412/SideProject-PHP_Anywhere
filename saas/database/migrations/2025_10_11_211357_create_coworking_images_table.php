<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('coworking_images', function (Blueprint $table) {
            $table->id();

            // Relazione con il modello "Coworking" (il tuo "Venue")
            $table->foreignId('coworking_id')
                ->constrained('coworkings') // nome della tabella dei venue
                ->cascadeOnDelete();

            $table->string('path');      // chiave/filename su S3
            $table->string('caption')->nullable();  // didascalia opzionale

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('coworking_images');
    }
};
