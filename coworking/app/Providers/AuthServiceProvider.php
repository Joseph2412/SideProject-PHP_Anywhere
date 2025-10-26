<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\Coworking;
use App\Policies\CoworkingPolicy;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Coworking::class => CoworkingPolicy::class,
    ];

    public function boot(): void
    {
        //
    }
}
