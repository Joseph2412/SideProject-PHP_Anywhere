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
    protected static string $view = 'filament.pages.global-theme-designer';
    
    // CSS predefiniti per diversi componenti Filament
    public array $componentStyles = [
        'form-inputs' => [
            'label' => 'Input Forms (TextInput, Select, Textarea)',
            'description' => 'Stili per tutti gli input dei form',
            'css' => '',
            'selectors' => [
                '.fi-input',
                '.fi-fo-text-input .fi-input',
                '.fi-fo-textarea .fi-input',
                '.fi-fo-select .fi-input'
            ]
        ],
        'buttons' => [
            'label' => 'Pulsanti Primari',
            'description' => 'Stili per i pulsanti principali',
            'css' => '',
            'selectors' => [
                '.fi-btn-primary',
                '.fi-btn',
                'button[type="submit"]'
            ]
        ],
        'cards' => [
            'label' => 'Card e Pannelli',
            'description' => 'Stili per card, pannelli e sezioni',
            'css' => '',
            'selectors' => [
                '.fi-section',
                '.fi-card',
                '.fi-resource-table'
            ]
        ],
        'navigation' => [
            'label' => 'Navigazione Sidebar',
            'description' => 'Stili per la navigazione laterale',
            'css' => '',
            'selectors' => [
                '.fi-sidebar',
                '.fi-sidebar-nav',
                '.fi-sidebar-nav-item'
            ]
        ],
        'tables' => [
            'label' => 'Tabelle',
            'description' => 'Stili per le tabelle di dati',
            'css' => '',
            'selectors' => [
                '.fi-ta-table',
                '.fi-ta-row',
                '.fi-ta-cell'
            ]
        ],
        'notifications' => [
            'label' => 'Notifiche',
            'description' => 'Stili per toast e notifiche',
            'css' => '',
            'selectors' => [
                '.fi-no-notification',
                '.fi-no-notification-body'
            ]
        ]
    ];
    
    public function mount(): void
    {
        $this->loadStyles();
    }
    
    private function loadStyles(): void
    {
        $stylePath = storage_path('app/filament-custom-theme.json');
        
        if (File::exists($stylePath)) {
            $savedStyles = json_decode(File::get($stylePath), true) ?? [];
            
            foreach ($this->componentStyles as $key => &$component) {
                $component['css'] = $savedStyles[$key] ?? '';
            }
        }
    }
    
    public function saveStyles(): void
    {
        $stylePath = storage_path('app/filament-custom-theme.json');
        $cssPath = storage_path('app/filament-custom-theme.css');
        
        // Estrai solo i CSS dai componentStyles
        $cssData = [];
        foreach ($this->componentStyles as $key => $component) {
            if (!empty(trim($component['css']))) {
                $cssData[$key] = $component['css'];
            }
        }
        
        // Salva il JSON
        File::put($stylePath, json_encode($cssData, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
        
        // Genera il CSS seguendo le convenzioni Filament
        $this->generateFilamentCss($cssData, $cssPath);
        
        Notification::make()
            ->title('🎨 Tema personalizzato salvato!')
            ->body('Gli stili sono stati applicati seguendo le best practices di Filament.')
            ->success()
            ->send();
    }
    
    private function generateFilamentCss(array $styles, string $cssPath): void
    {
        $css = "/* Filament Custom Theme - Enhanced with High Specificity */\n";
        $css .= "/* Generated following Filament best practices */\n";
        $css .= "/* https://filamentphp.com/docs/3.x/support/style-customization */\n\n";
        
        foreach ($styles as $key => $cssRules) {
            if (empty($cssRules)) continue;
            
            $component = $this->componentStyles[$key];
            $css .= "/* {$component['label']} - {$component['description']} */\n";
            
            // Crea selettori con maggiore specificità per sovrascrivere gli stili di default
            $enhancedSelectors = [];
            foreach ($component['selectors'] as $selector) {
                // Aggiungi prefissi per maggiore specificità
                $enhancedSelectors[] = ".fi-main {$selector}";
                $enhancedSelectors[] = ".fi-page {$selector}";
                $enhancedSelectors[] = "body.fi-body {$selector}";
                $enhancedSelectors[] = $selector; // Mantieni anche l'originale
            }
            
            $selectors = implode(",\n", $enhancedSelectors);
            
            // Aggiungi !important alle proprietà CSS per massima priorità
            $enhancedCssRules = $this->addImportantToRules($cssRules);
            
            $css .= "{$selectors} {\n";
            $css .= "    {$enhancedCssRules}\n";
            $css .= "}\n\n";
        }
        
        File::put($cssPath, $css);
    }
    
    private function addImportantToRules(string $cssRules): string
    {
        // Aggiungi !important a ogni regola CSS che non ce l'ha già
        $rules = explode(';', $cssRules);
        $enhancedRules = [];
        
        foreach ($rules as $rule) {
            $rule = trim($rule);
            if (empty($rule)) continue;
            
            // Se la regola non ha già !important, aggiungilo
            if (!str_contains($rule, '!important')) {
                $rule .= ' !important';
            }
            $enhancedRules[] = $rule;
        }
        
        return implode('; ', $enhancedRules);
    }
    
    public function clearStyles(): void
    {
        foreach ($this->componentStyles as &$component) {
            $component['css'] = '';
        }
        
        $paths = [
            storage_path('app/filament-custom-theme.json'),
            storage_path('app/filament-custom-theme.css')
        ];
        
        foreach ($paths as $path) {
            if (File::exists($path)) {
                File::delete($path);
            }
        }
        
        Notification::make()
            ->title('🗑️ Tema personalizzato rimosso')
            ->body('Ripristinati gli stili predefiniti di Filament.')
            ->success()
            ->send();
    }
    
    public function applyPreset(string $presetName): void
    {
        $presets = [
            'dark-mode' => [
                'form-inputs' => 'background-color: #374151; border-color: #6b7280; color: #f9fafb;',
                'buttons' => 'background-color: #1f2937; border-color: #374151; color: #f9fafb;',
                'cards' => 'background-color: #1f2937; border-color: #374151;'
            ],
            'colorful' => [
                'form-inputs' => 'background-color: #fef3c7; border: 2px solid #f59e0b; border-radius: 8px;',
                'buttons' => 'background: linear-gradient(45deg, #3b82f6, #8b5cf6); color: white; border-radius: 8px;',
                'cards' => 'background: linear-gradient(135deg, #f3f4f6, #e5e7eb); border-radius: 12px;'
            ],
            'minimal' => [
                'form-inputs' => 'border: 1px solid #e5e7eb; border-radius: 4px; box-shadow: none;',
                'buttons' => 'border-radius: 4px; box-shadow: none; border: 1px solid #d1d5db;',
                'cards' => 'border: 1px solid #e5e7eb; border-radius: 6px; box-shadow: none;'
            ]
        ];
        
        if (isset($presets[$presetName])) {
            foreach ($presets[$presetName] as $key => $css) {
                if (isset($this->componentStyles[$key])) {
                    $this->componentStyles[$key]['css'] = $css;
                }
            }
            
            $this->saveStyles();
            
            Notification::make()
                ->title("🎨 Preset '{$presetName}' applicato!")
                ->success()
                ->send();
        }
    }
}
