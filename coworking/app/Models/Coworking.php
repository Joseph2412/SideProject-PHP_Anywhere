<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coworking extends Model
{
 
    
    /**
     * Relazione: un coworking appartiene a un host (utente)
     */
    public function host()
    {
        return $this->belongsTo(User::class, 'host_id');
    }
}
