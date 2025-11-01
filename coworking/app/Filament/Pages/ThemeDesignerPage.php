<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Illuminate\Support\Facades\File;
use Filament\Notifications\Notification;

class ThemeDesignerPage extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-swatch';
    protected static ?string $navigationLabel = 'Theme Designer';
    protected static ?string $navigationGroup = 'Theme Manager';
    protected static ?string $slug = 'theme-designer';
    protected static string $view = 'filament.pages.theme-designer';
    
    public array $groupedComponents = [];
    public array $styles = [];
    
    public function mount(): void
    {
        $this->loadComponents();
        $this->loadStyles();
    }
    
    private function loadComponents(): void
    {
        $jsonPath = storage_path('app/filament-components.json');
        
        if (! File::exists($jsonPath)) {
            $this->groupedComponents = [];
            return;
        }
        
        $data = json_decode(File::get($jsonPath), true) ?? [];
        
        // Raggruppa per file/resource
        $this->groupedComponents = collect($data)->groupBy('file')->toArray();
    }
    
    private function loadStyles(): void
    {
        $stylePath = storage_path('app/filament-theme-overrides.json');
        if (File::exists($stylePath)) {
            $this->styles = json_decode(File::get($stylePath), true) ?? [];
        } else {
            $this->styles = [];
        }
    }
    
    public function saveStyles(): void
    {
        
        $stylePath = storage_path('app/filament-theme-overrides.json');
        
        // 🔹 Carica JSON esistente in modo sicuro
        $existing = [];
        if (File::exists($stylePath)) {
            $json = File::get($stylePath);
            $decoded = json_decode($json, true);
            
            // Se il JSON è valido e un array
            if (is_array($decoded)) {
                $existing = $decoded;
            }
        }
        
        // 🔹 Assicura che Livewire stia fornendo un array puro
        $current = is_array($this->styles)
        ? $this->styles
        : (array) $this->styles;
        
        // 🔹 Merge sicuro e override dei duplicati
        $merged = array_merge($existing, $current);
        
        // 🔹 Scrive il file in modo atomico
        File::put($stylePath, json_encode($merged, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
        
        \Filament\Notifications\Notification::make()
        ->title('🎨 Stili aggiornati correttamente!')
        ->success()
        ->send();
    }

    private function getComponentKey(array $component, string $file): string
    {
        return md5($file . '_' . ($component['component'] ?? '') . '_' . ($component['field'] ?? ''));
    }
    
    
}
