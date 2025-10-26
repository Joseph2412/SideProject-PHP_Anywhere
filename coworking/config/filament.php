<?php

use Filament\Panel;
use Filament\PanelProvider;
use Filament\Pages;
use Filament\Widgets;
use App\Filament\Admin;
use App\Filament\Host;

return [

    /*
    |--------------------------------------------------------------------------
    | Default Panel
    |--------------------------------------------------------------------------
    */
    'default_panel' => 'admin',

    /*
    |--------------------------------------------------------------------------
    | Panels Configuration
    |--------------------------------------------------------------------------
    */
    'panels' => [

        'admin' => [
            'id' => 'admin',
            'path' => 'admin',
            'auth_guard' => 'web',
            'discover' => [
                'resources' => [
                    'path' => app_path('Filament/Admin/Resources'),
                    'namespace' => 'App\\Filament\\Admin\\Resources',
                ],
                'pages' => [
                    'path' => app_path('Filament/Admin/Pages'),
                    'namespace' => 'App\\Filament\\Admin\\Pages',
                ],
            ],
            'brand' => [
                'name' => 'KWORK • Admin',
                'logo' => 'images/kwork-logo.svg',
            ],
        ],

        'host' => [
            'id' => 'host',
            'path' => 'host',
            'auth_guard' => 'web',
            'discover' => [
                'resources' => [
                    'path' => app_path('Filament/Host/Resources'),
                    'namespace' => 'App\\Filament\\Host\\Resources',
                ],
                'pages' => [
                    'path' => app_path('Filament/Host/Pages'),
                    'namespace' => 'App\\Filament\\Host\\Pages',
                ],
            ],
            'brand' => [
                'name' => 'KWORK • Host',
                'logo' => 'images/kwork-logo.svg',
            ],
        ],

    ],

];
