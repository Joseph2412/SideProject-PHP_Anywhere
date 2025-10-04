<?php

namespace App\Providers\Filament;

use Filament\Panel;
use Filament\PanelProvider;
use Filament\Http\Middleware\Authenticate; 
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Filament\Pages; // 
use App\Http\Middleware\HostOnly;

class HostPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('host')
            ->path('host')                 
            // ->login(CommonLogin::class)    // Login unificato
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                \App\Http\Middleware\HostOnly::class, // Middleware per controllo accesso Host
            ])
            ->authMiddleware([
                Authenticate::class,
                HostOnly::class, 
            ])
            // Scopri solo le risorse/pagine del namespace Host
            ->discoverResources(
                in: app_path('Filament/Host/Resources'),
                for: 'App\\Filament\\Host\\Resources'
            )
            ->discoverPages(
                in: app_path('Filament/Host/Pages'),
                for: 'App\\Filament\\Host\\Pages'
            )
            // Dashboard base subito disponibile
            ->pages([
                Pages\Dashboard::class,
            ]);
    }
}
