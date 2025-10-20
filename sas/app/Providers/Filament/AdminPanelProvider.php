<?php

namespace App\Providers\Filament;

use Filament\Facades\Filament;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Http\Responses\Auth\Contracts\LoginResponse as LoginResponseContract;
use App\Http\Responses\Auth\RedirectAfterLogin;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('admin')
            ->path('') // 👈 imposta path vuoto per usare /login
            ->login() // login nativa Filament
            ->brandName('Coworking Anywhere')
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->authMiddleware([\App\Http\Middleware\Authenticate::class]);
    }

    public function boot(): void
    {
        Filament::serving(function () {
            app()->bind(LoginResponseContract::class, RedirectAfterLogin::class);
        });
    }
}
