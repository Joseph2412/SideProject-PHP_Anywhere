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
        Schema::table('coworkings', function (Blueprint $table) {
            // Aggiungi il campo images come JSON se non esiste già
            if (!Schema::hasColumn('coworkings', 'images')) {
                $table->json('images')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('coworkings', function (Blueprint $table) {
            $table->dropColumn('images');
        });
    }
};
