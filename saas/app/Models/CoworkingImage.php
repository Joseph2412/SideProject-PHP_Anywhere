<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class CoworkingImage extends Model
{
    use HasFactory;

    /**
     * Tabella esplicita (facoltativo se rispetti convenzioni).
     */
    protected $table = 'coworking_images';

    /**
     * Attributi assegnabili in massa.
     */
    protected $fillable = [
        'coworking_id',   // FK verso Coworking
        'path',       // percorso/chiave nel bucket S3 (es. "coworkings/123/xyz.jpg")
        'caption',    // descrizione didascalia (opzionale)
    ];

    /**
     * Relazione: ogni immagine appartiene a un singolo Coworking.
     */
    public function coworking(): BelongsTo
    {
        return $this->belongsTo(Coworking::class, 'coworking_id');
    }

    /**
     * Accessor comodo: URL pubblico dell'immagine S3.
     */
    public function getUrlAttribute(): string
    {
        // Se è configurato S3, usa Storage::url() direttamente
        if (config('filesystems.disks.s3.key')) {
            return Storage::url($this->path);
        }
        
        // Fallback su storage pubblico locale
        return asset('storage/' . $this->path);
    }
}
