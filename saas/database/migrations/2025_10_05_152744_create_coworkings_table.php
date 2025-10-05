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
        Schema::create('coworkings', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('address');
            $table->string('city');
            $table->string('country')->default('Italia');
            $table->decimal('price_per_hour', 8, 2)->nullable();
            $table->decimal('price_per_day', 8, 2)->nullable();
            $table->integer('capacity');
            $table->string('amenities')->nullable(); // Stringa separata da virgole
            $table->enum('space_type', [
                'open_space', 
                'private_office', 
                'meeting_room', 
                'conference_room',
                'hot_desk'
            ]);
            $table->string('availability')->nullable(); // Stringa libera per orari
            $table->enum('status', ['open', 'closed', 'inactive'])->default('inactive');
            $table->foreignId('host_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coworkings');
    }
};
