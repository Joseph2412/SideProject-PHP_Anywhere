<?php

namespace App\Providers;

use Filament\Facades\Filament;
use Filament\Support\Assets\Css;
use Filament\Support\Facades\FilamentAsset;
use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;

class FilamentThemeOverrideServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Filament::serving(function () {
            $jsonPath = storage_path('app/filament-theme-overrides.json');

            if (! File::exists($jsonPath)) {
                return;
            }

            $overrides = json_decode(File::get($jsonPath), true);

            if (empty($overrides) || !is_array($overrides)) {
                return;
            }

            // 🔹 Costruisci CSS dinamico
            $css = "/* --- Filament Theme Overrides --- */\n";
            foreach ($overrides as $hash => $rule) {
                // Ogni regola viene racchiusa in un selettore "globale"
                $css .= ":root { {$rule} }\n";
            }

            // 🔹 Salva temporaneamente il CSS generato
            $tempCssPath = storage_path('app/filament-theme-overrides.css');
            File::put($tempCssPath, $css);

            // 🔹 Registra e applica il CSS
            FilamentAsset::register([
                Css::make('filament-theme-overrides', $tempCssPath),
            ]);
        });
    }
}
