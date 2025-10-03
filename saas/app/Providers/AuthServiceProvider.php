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

        Gate::before(function($user, $ability){
            return $user->role==="Admin" ? true : null;
        });
    }
}
