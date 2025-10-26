<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coworking extends Model
{
    use HasFactory;

    protected $fillable = [
        'host_id',
        'name',
        'description',
        'is_active',
    ];

    // Relazioni
    public function host()
    {
        return $this->belongsTo(User::class, 'host_id');
    }

    // Prossime implementazioni:
    // public function spaces() { return $this->hasMany(Space::class); }
    // public function bookings() { return $this->hasManyThrough(Booking::class, Space::class); }
    // public function images() { return $this->hasMany(Image::class); }
}
