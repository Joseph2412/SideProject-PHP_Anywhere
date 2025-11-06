<?php

namespace App\Providers;

use Filament\Facades\Filament;
use Filament\Support\Assets\Css;
use Filament\Support\Facades\FilamentAsset;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class FilamentThemeOverrideServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Registra il CSS durante il serving di Filament
        Filament::serving(function () {
            $this->registerThemeAssets();
        });
        
        // Aggiungi CSS inline tramite View Composer per massima priorità
        View::composer('filament::*', function ($view) {
            $this->injectCustomStyles();
        });
    }
    
    private function registerThemeAssets(): void
    {
        $cssPath = storage_path('app/filament-custom-theme.css');
        
        if (File::exists($cssPath)) {
            // Registra il CSS con massima priorità
            FilamentAsset::register([
                Css::make('filament-custom-theme', $cssPath),
            ]);
        }
    }
    
    private function injectCustomStyles(): void
    {
        $cssPath = storage_path('app/filament-custom-theme.css');
        
        if (File::exists($cssPath)) {
            $cssContent = File::get($cssPath);
            
            // Aggiungi stili con !important per sovrascrivere definitivamente
            $enhancedCss = $this->addImportantToCss($cssContent);
            
            // Inject nel DOM tramite script inline
            echo "<style id='filament-custom-theme-inline'>\n{$enhancedCss}\n</style>";
        }
    }
    
    private function addImportantToCss(string $css): string
    {
        // Aggiungi !important a tutte le proprietà CSS per massima priorità
        $css = preg_replace('/;(\s*)/m', ' !important;$1', $css);
        return $css;
    }
}
