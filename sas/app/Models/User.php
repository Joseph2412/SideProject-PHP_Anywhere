<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    public function isAdmin(): bool {
        return $this->role === 'admin';
    }

    public function isHost(): bool {
        return $this->role === 'host';
    }

    // Relazioni base (verranno create nella Fase 2)
    public function coworkings(): HasMany {
        return $this->hasMany(Coworking::class);
    }

    public function bookings(): HasMany {
        return $this->hasMany(Booking::class);
    }
}
