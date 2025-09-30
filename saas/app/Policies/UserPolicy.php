<?php 

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

/**
     * Determina se l'utente può vedere la lista utenti.
     */
    public function viewAny(User $user): bool
    {
        // Solo ADMIN può accedere alla lista utenti
        return $user->role==='Admin';
    }

    /**
     * Determina se l'utente può vedere un singolo utente.
     */
    public function view(User $user, User $model): bool
    {
        // L'ADMIN può vedere chiunque
        if ($user->role==='Admin') {
            return true;
        }

        // Un HOST può vedere solo sé stesso
        if ($user->role==='Host') {
            return $user->id === $model->id;
        }

        return false;
    }

    /**
     * Determina se l'utente può creare nuovi utenti.
     */
    public function create(User $user): bool
    {
        return $user->role==='Admin';
    }

    /**
     * Determina se l'utente può aggiornare un utente.
     */
    public function update(User $user, User $model): bool
    {
        return $user->role==='Admin';
    }

    /**
     * Determina se l'utente può eliminare un utente.
     */
    public function delete(User $user, User $model): bool
    {
        return $user->role==='Admin';
    }

    /**
     * Determina se l'utente può vedere i log di audit o azioni speciali.
     * (Opzionale, solo esempio)
     */
    public function viewLogs(User $user): bool
    {
        return $user->role==='Admin';
    }
}