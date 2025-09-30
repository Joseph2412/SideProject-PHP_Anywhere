<?php

namespace App\Providers;

use App\Models\User;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Le policy della tua applicazione.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // Qui colleghi il modello User alla sua policy
        User::class => UserPolicy::class,
    ];

    /**
     * Registra eventuali servizi di autenticazione / autorizzazione.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // Se usi Gates personalizzati, puoi definirli qui:
        /*
        Gate::define('view-dashboard', function (User $user) {
            return $user->hasRole('ADMIN');
        });
        */
    }
}
