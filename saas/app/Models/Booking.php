<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Booking extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'coworking_id',
        'costumer_name',
        'costumer_email',
        'booking_date',
        'start_time',
        'end_time',
        'guests_count',
        'total_price',
        'booking_type',
        'status',
        'notes',
        'special_requests',
        'payment_status',
        'payment_method',
        'cancelled_at',
        'cancellation_reason',
    ];

    protected $casts = [
        'booking_date' => 'date',
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
        'guests_count' => 'integer',
        'total_price' => 'decimal:2',
        'cancelled_at' => 'datetime',
    ];

    // Relazione con Coworking
    public function coworking(): BelongsTo
    {
        return $this->belongsTo(Coworking::class);
    }

    // Accessor per ottenere la durata in ore
    public function getDurationInHoursAttribute(): float
    {
        $start = Carbon::createFromFormat('H:i:s', $this->start_time);
        $end = Carbon::createFromFormat('H:i:s', $this->end_time);
        
        return $end->diffInHours($start, true);
    }

    // Accessor per ottenere il slot orario formattato
    public function getFormattedTimeSlotAttribute(): string
    {
        return $this->start_time . ' - ' . $this->end_time;
    }

    // Scope per prenotazioni di oggi
    public function scopeToday($query)
    {
        return $query->whereDate('booking_date', today());
    }

    // Scope per prenotazioni future
    public function scopeUpcoming($query)
    {
        return $query->where('booking_date', '>=', today());
    }

    // Scope per prenotazioni passate
    public function scopePast($query)
    {
        return $query->where('booking_date', '<', today());
    }

    // Scope per prenotazioni di un coworking specifico
    public function scopeForCoworking($query, $coworkingId)
    {
        return $query->where('coworking_id', $coworkingId);
    }

    // Scope per prenotazioni di una data specifica
    public function scopeForDate($query, $date)
    {
        return $query->whereDate('booking_date', $date);
    }

    // Verifica se la prenotazione è in conflitto con un'altra
    public function hasConflictWith($date, $startTime, $endTime, $coworkingId, $excludeId = null)
    {
        $query = static::where('coworking_id', $coworkingId)
            ->whereDate('booking_date', $date)
            ->where(function ($q) use ($startTime, $endTime) {
                $q->whereBetween('start_time', [$startTime, $endTime])
                  ->orWhereBetween('end_time', [$startTime, $endTime])
                  ->orWhere(function ($q2) use ($startTime, $endTime) {
                      $q2->where('start_time', '<=', $startTime)
                         ->where('end_time', '>=', $endTime);
                  });
            });

        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        return $query->exists();
    }

    // Metodo helper per verificare se la prenotazione è per oggi
    public function isToday(): bool
    {
        return $this->booking_date->isToday();
    }

    // Metodo helper per verificare se la prenotazione è futura
    public function isFuture(): bool
    {
        return $this->booking_date->isFuture();
    }

    // Metodo helper per verificare se la prenotazione è passata
    public function isPast(): bool
    {
        return $this->booking_date->isPast();
    }
}
