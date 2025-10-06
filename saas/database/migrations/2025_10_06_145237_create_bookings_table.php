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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            
            // Relazioni
            
            $table->foreignId('coworking_id')->constrained('coworkings')->onDelete('cascade');
            
            $table->string("costumer_name");
            $table->string("costumer_email")->nullable(); //Puoi anche evitare di mettere la mail

            // Date e orari
            $table->date('booking_date');
            $table->time('start_time');
            $table->time('end_time');
            
            // Dettagli prenotazione
            $table->integer('guests_count')->default(1);
            $table->decimal('total_price', 8, 2);
            $table->enum('booking_type', ['hourly', 'daily'])->default('hourly');
            
            // Status della prenotazione
            $table->enum('status', [
                'pending', 
                'confirmed', 
                'cancelled', 
                'completed',
                'no_show'
            ])->default('pending');
            
            // Note e dettagli aggiuntivi
            $table->text('notes')->nullable();
            $table->text('special_requests')->nullable();
            
            // Dati di pagamento
            $table->enum('payment_status', [
                'pending', 
                'paid', 
                'refunded', 
                'failed'
            ])->default('pending');
            $table->string('payment_method')->nullable();
            
            // Cancellazione
            $table->timestamp('cancelled_at')->nullable();
            $table->text('cancellation_reason')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
            
            // Indici per performance
            $table->index(['booking_date', 'start_time']);
            $table->index(['costumer_name', 'status']);
            $table->index(['coworking_id', 'booking_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
