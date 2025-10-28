<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;
use Filament\Panel;

class Coworking extends Model
{

    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */


    protected $fillable = [
        'name',
        'description',
        'city',
        'address',
        'host_id',
    ];
    
  /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function canAccessPanel(Panel $panel): bool
    {
        // Consenti accesso solo al pannello host se l'utente ha ruolo host
        return $panel->getId() === 'host' && $this->role === 'host';
    }


    /**
     * Relazione: un coworking appartiene a un host (utente)
     */
    public function host()
    {
        return $this->belongsTo(User::class, 'host_id');
    }
}
