<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Illuminate\Support\Facades\Artisan;

use Illuminate\Support\Facades\File;

class ComponentScannerPage extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-magnifying-glass';
    protected static ?string $navigationLabel = 'Component Scanner';
    protected static ?string $navigationGroup = 'Theme Manager';
    protected static string $view = 'filament.pages.component-scanner';
    protected static ?string $slug = 'components-scan';


    public array $components = [];

    public function mount(): void
    {
        $jsonPath = storage_path('app/filament-components.json');

        if (File::exists($jsonPath)) {
            $this->components = json_decode(File::get($jsonPath), true) ?? [];
        } else {
            $this->components = [];
        }
    }
    public function refreshScan(): void
    {
        Artisan::call('filament:scan');
        $this->mount();
    }
}
