<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coworking extends Model
{
    use HasFactory, SoftDeletes;

    // Campo usato come titolo da Filament
    protected static ?string $title = 'name';

    protected $fillable = [
        'name',
        'description',
        'address',
        'city',
        'country',
        'price_per_hour',
        'price_per_day',
        'capacity',
        'amenities',
        'space_type',
        'availability_hours',
        'images',
        'status',
        'host_id',
    ];

    protected $casts = [
        'amenities' => 'array',
        'images' => 'array',
        'price_per_hour' => 'decimal:2',
        'price_per_day' => 'decimal:2',
        'availability_hours' => 'array',
    ];

    // Relazione con l'Host (User)
    public function host()
    {
        return $this->belongsTo(User::class, 'host_id');
    }

    // Relazione con le prenotazioni
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    // Metodi utili per le prenotazioni
    public function activeBookings()
    {
        return $this->bookings()->active();
    }

    public function todayBookings()
    {
        return $this->bookings()->today();
    }

    public function upcomingBookings()
    {
        return $this->bookings()->upcoming();
    }

    public function getAvailabilityForDate($date)
    {
        $bookings = $this->bookings()
            ->whereDate('booking_date', $date)
            ->where('status', '!=', 'cancelled')
            ->get();

        return $bookings;
    }
}