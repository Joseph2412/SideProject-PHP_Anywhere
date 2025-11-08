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
    
    // CSS predefiniti per tutti i componenti Filament seguendo le hook class abbreviations
    public array $componentStyles = [
        // ========== Actions Package (fi-ac) ==========
        'actions-buttons' => [
            'label' => '🎬 Actions - Pulsanti Base',
            'description' => 'Pulsanti standard delle Actions (btn = button)',
            'css' => '',
            'selectors' => [
                '.fi-ac-btn',
                '.fi-ac-btn-primary',
                '.fi-ac-btn-secondary',
                '.fi-ac-action .fi-btn',
                // Includi pulsanti dentro tabelle e pannelli
                '.fi-ta-table .fi-btn',
                '.fi-section .fi-btn',
                '.fi-card .fi-btn',
                '.fi-panel .fi-btn',
                '.fi-modal .fi-btn',
                '.fi-header-actions .fi-btn',
                '.fi-table-actions .fi-btn',
                'button.fi-btn'
            ]
        ],
        'actions-buttons-create' => [
            'label' => '🎬 Actions - Pulsanti Crea',
            'description' => 'Pulsanti specifici per creare nuovi record',
            'css' => '',
            'selectors' => [
                '.fi-ac-btn-create',
                '.fi-header-actions .fi-btn[wire\\:click*="create"]',
                '.fi-create-action .fi-btn',
                // Includi pulsanti create ovunque
                '.fi-ta-table .fi-btn[wire\\:click*="create"]',
                '.fi-section .fi-btn[wire\\:click*="create"]',
                '.fi-card .fi-btn[wire\\:click*="create"]',
                '.fi-panel .fi-btn[wire\\:click*="create"]'
            ]
        ],
        'actions-buttons-edit' => [
            'label' => '🎬 Actions - Pulsanti Modifica',
            'description' => 'Pulsanti per modificare record esistenti',
            'css' => '',
            'selectors' => [
                '.fi-ac-btn-edit',
                '.fi-table-actions .fi-btn[wire\\:click*="edit"]',
                '.fi-edit-action .fi-btn',
                // Includi pulsanti edit ovunque
                '.fi-ta-table .fi-btn[wire\\:click*="edit"]',
                '.fi-section .fi-btn[wire\\:click*="edit"]',
                '.fi-card .fi-btn[wire\\:click*="edit"]',
                '.fi-panel .fi-btn[wire\\:click*="edit"]'
            ]
        ],
        'actions-buttons-delete' => [
            'label' => '🎬 Actions - Pulsanti Elimina',
            'description' => 'Pulsanti per eliminare record (con stili warning/danger)',
            'css' => '',
            'selectors' => [
                '.fi-ac-btn-delete',
                '.fi-table-actions .fi-btn[wire\\:click*="delete"]',
                '.fi-delete-action .fi-btn',
                // Includi pulsanti delete ovunque
                '.fi-ta-table .fi-btn[wire\\:click*="delete"]',
                '.fi-section .fi-btn[wire\\:click*="delete"]',
                '.fi-card .fi-btn[wire\\:click*="delete"]',
                '.fi-panel .fi-btn[wire\\:click*="delete"]'
            ]
        ],
        'actions-buttons-view' => [
            'label' => '🎬 Actions - Pulsanti Visualizza',
            'description' => 'Pulsanti per visualizzare dettagli record',
            'css' => '',
            'selectors' => [
                '.fi-ac-btn-view',
                '.fi-table-actions .fi-btn[wire\\:click*="view"]',
                '.fi-view-action .fi-btn',
                // Includi pulsanti view ovunque
                '.fi-ta-table .fi-btn[wire\\:click*="view"]',
                '.fi-section .fi-btn[wire\\:click*="view"]',
                '.fi-card .fi-btn[wire\\:click*="view"]',
                '.fi-panel .fi-btn[wire\\:click*="view"]'
            ]
        ],
        'actions-containers' => [
            'label' => '🎬 Actions - Contenitori',
            'description' => 'Contenitori e wrapper delle Actions (ctn = container, wrp = wrapper)',
            'css' => '',
            'selectors' => [
                '.fi-ac-ctn',
                '.fi-ac-wrp',
                '.fi-action-container',
                '.fi-actions-wrapper'
            ]
        ],
        
        // ========== Forms Package (fi-fo) ==========
        'forms-inputs' => [
            'label' => '📝 Forms - Input Base',
            'description' => 'Input di testo, select, textarea (tutti gli input forms)',
            'css' => '',
            'selectors' => [
                '.fi-fo-text-input .fi-input',
                '.fi-fo-textarea .fi-input',
                '.fi-fo-select .fi-input',
                '.fi-fo-date-time-picker .fi-input',
                '.fi-input',
                // Includi input dentro tabelle e pannelli
                '.fi-ta-table .fi-input',
                '.fi-section .fi-input',
                '.fi-card .fi-input',
                '.fi-panel .fi-input',
                '.fi-modal .fi-input',
                '.fi-page .fi-input input',
                'input[type="text"]',
                'input[type="email"]',
                'input[type="password"]',
                'input[type="number"]'
            ]
        ],
        'forms-textarea' => [
            'label' => '📝 Forms - Textarea Specifici',
            'description' => 'Aree di testo multiriga',
            'css' => '',
            'selectors' => [
                '.fi-fo-textarea .fi-input',
                '.fi-fo-textarea textarea',
                'textarea.fi-input',
                // Includi textarea dentro contenitori
                '.fi-ta-table textarea',
                '.fi-section textarea',
                '.fi-card textarea',
                '.fi-panel textarea',
                '.fi-modal textarea',
                'textarea'
            ]
        ],
        'forms-checkbox' => [
            'label' => '☑️ Forms - Checkbox',
            'description' => 'Checkbox e elementi selezionabili',
            'css' => '',
            'selectors' => [
                '.fi-fo-checkbox .fi-checkbox-input',
                '.fi-fo-checkbox input[type="checkbox"]',
                '.fi-checkbox',
                // Includi checkbox dentro contenitori
                '.fi-ta-table input[type="checkbox"]',
                '.fi-section input[type="checkbox"]',
                '.fi-card input[type="checkbox"]',
                '.fi-panel input[type="checkbox"]',
                'input[type="checkbox"]'
            ]
        ],
        'forms-radio' => [
            'label' => '🔘 Forms - Radio Buttons',
            'description' => 'Radio button e opzioni singole',
            'css' => '',
            'selectors' => [
                '.fi-fo-radio .fi-radio-input',
                '.fi-fo-radio input[type="radio"]',
                '.fi-radio',
                // Includi radio dentro contenitori
                '.fi-ta-table input[type="radio"]',
                '.fi-section input[type="radio"]',
                '.fi-card input[type="radio"]',
                '.fi-panel input[type="radio"]',
                'input[type="radio"]'
            ]
        ],
        'forms-toggle' => [
            'label' => '🔄 Forms - Toggle/Switch',
            'description' => 'Interruttori e toggle switch',
            'css' => '',
            'selectors' => [
                '.fi-fo-toggle .fi-toggle-input',
                '.fi-fo-toggle',
                '.fi-toggle',
                // Includi toggle dentro contenitori
                '.fi-ta-table .fi-toggle',
                '.fi-section .fi-toggle',
                '.fi-card .fi-toggle',
                '.fi-panel .fi-toggle'
            ]
        ],
        'forms-file-upload' => [
            'label' => '📎 Forms - File Upload',
            'description' => 'Componenti di upload file',
            'css' => '',
            'selectors' => [
                '.fi-fo-file-upload',
                '.fi-fo-file-upload .fi-fo-file-upload-dropzone',
                '.fi-file-upload',
                // Includi file upload dentro contenitori
                '.fi-section .fi-file-upload',
                '.fi-card .fi-file-upload',
                '.fi-panel .fi-file-upload',
                '.fi-modal .fi-file-upload'
            ]
        ],
        'forms-rich-editor' => [
            'label' => '📝 Forms - Editor Ricco',
            'description' => 'Editor rich text e markdown',
            'css' => '',
            'selectors' => [
                '.fi-fo-rich-editor',
                '.fi-fo-rich-editor .fi-rich-editor',
                '.fi-rich-editor',
                // Includi editor dentro contenitori
                '.fi-section .fi-rich-editor',
                '.fi-card .fi-rich-editor',
                '.fi-panel .fi-rich-editor',
                '.fi-modal .fi-rich-editor'
            ]
        ],
        'forms-buttons' => [
            'label' => '📝 Forms - Pulsanti Forms',
            'description' => 'Pulsanti specifici dei form (btn = button)',
            'css' => '',
            'selectors' => [
                '.fi-fo-btn',
                '.fi-fo-btn-primary',
                '.fi-form-btn',
                'button[type="submit"]',
                // Includi pulsanti form dentro contenitori
                '.fi-section button[type="submit"]',
                '.fi-card button[type="submit"]',
                '.fi-panel button[type="submit"]',
                '.fi-modal button[type="submit"]',
                '.fi-ta-table button[type="submit"]'
            ]
        ],
        'forms-containers' => [
            'label' => '📝 Forms - Contenitori Form',
            'description' => 'Sezioni e contenitori dei form (ctn = container)',
            'css' => '',
            'selectors' => [
                '.fi-fo-ctn',
                '.fi-fo-section',
                '.fi-form-section',
                '.fi-fieldset'
            ]
        ],
        'forms-wrappers' => [
            'label' => '📝 Forms - Wrapper Campi',
            'description' => 'Wrapper dei singoli campi form (wrp = wrapper)',
            'css' => '',
            'selectors' => [
                '.fi-fo-wrp',
                '.fi-fo-field-wrp',
                '.fi-field-wrapper'
            ]
        ],
        
        // ========== Infolists Package (fi-in) ==========
        'infolists-containers' => [
            'label' => '📋 Infolists - Contenitori',
            'description' => 'Contenitori e sezioni delle infolists (ctn = container)',
            'css' => '',
            'selectors' => [
                '.fi-in-ctn',
                '.fi-in-section',
                '.fi-infolist-section'
            ]
        ],
        'infolists-entries' => [
            'label' => '📋 Infolists - Voci Entry',
            'description' => 'Singole voci delle infolists',
            'css' => '',
            'selectors' => [
                '.fi-in-entry',
                '.fi-in-text-entry',
                '.fi-infolist-entry'
            ]
        ],
        
        // ========== Notifications Package (fi-no) ==========
        'notifications-base' => [
            'label' => '🔔 Notifications - Notifiche Base',
            'description' => 'Toast e notifiche generali',
            'css' => '',
            'selectors' => [
                '.fi-no-notification',
                '.fi-no-notification-body',
                '.fi-notification'
            ]
        ],
        'notifications-buttons' => [
            'label' => '🔔 Notifications - Pulsanti Notifiche',
            'description' => 'Pulsanti all\'interno delle notifiche (btn = button)',
            'css' => '',
            'selectors' => [
                '.fi-no-btn',
                '.fi-no-notification .fi-btn',
                '.fi-notification-action'
            ]
        ],
        
        // ========== Schema/Components Package (fi-sc) ==========
        'schema-containers' => [
            'label' => '🔧 Schema - Contenitori',
            'description' => 'Contenitori dei componenti schema (ctn = container)',
            'css' => '',
            'selectors' => [
                '.fi-sc-ctn',
                '.fi-schema-container',
                '.fi-component-container'
            ]
        ],
        'schema-wrappers' => [
            'label' => '🔧 Schema - Wrapper Componenti',
            'description' => 'Wrapper dei componenti schema (wrp = wrapper)',
            'css' => '',
            'selectors' => [
                '.fi-sc-wrp',
                '.fi-schema-wrapper',
                '.fi-component-wrapper'
            ]
        ],
        
        // ========== Tables Package (fi-ta) ==========
        'tables-main' => [
            'label' => '📊 Tables - Tabelle Principali',
            'description' => 'Struttura principale delle tabelle',
            'css' => '',
            'selectors' => [
                '.fi-ta-table',
                '.fi-ta-table-container',
                '.fi-table'
            ]
        ],
        'tables-rows' => [
            'label' => '📊 Tables - Righe Tabella',
            'description' => 'Righe delle tabelle dati',
            'css' => '',
            'selectors' => [
                '.fi-ta-row',
                '.fi-ta-header-row',
                '.fi-table-row'
            ]
        ],
        'tables-cells' => [
            'label' => '📊 Tables - Celle Tabella',
            'description' => 'Celle individuali delle tabelle',
            'css' => '',
            'selectors' => [
                '.fi-ta-cell',
                '.fi-ta-header-cell',
                '.fi-table-cell'
            ]
        ],
        'tables-columns' => [
            'label' => '📊 Tables - Colonne',
            'description' => 'Colonne specifiche delle tabelle (col = column)',
            'css' => '',
            'selectors' => [
                '.fi-ta-col',
                '.fi-ta-column',
                '.fi-table-column'
            ]
        ],
        'tables-buttons' => [
            'label' => '📊 Tables - Pulsanti Tabelle',
            'description' => 'Pulsanti all\'interno delle tabelle (btn = button)',
            'css' => '',
            'selectors' => [
                '.fi-ta-btn',
                '.fi-ta-actions .fi-btn',
                '.fi-table-action'
            ]
        ],
        
        // ========== Widgets Package (fi-wi) ==========
        'widgets-containers' => [
            'label' => '📈 Widgets - Contenitori Widget',
            'description' => 'Contenitori principali dei widget (ctn = container)',
            'css' => '',
            'selectors' => [
                '.fi-wi-ctn',
                '.fi-widget-container',
                '.fi-widget'
            ]
        ],
        'widgets-wrappers' => [
            'label' => '📈 Widgets - Wrapper Widget',
            'description' => 'Wrapper interni dei widget (wrp = wrapper)',
            'css' => '',
            'selectors' => [
                '.fi-wi-wrp',
                '.fi-widget-wrapper',
                '.fi-widget-content'
            ]
        ],
        
        // ========== Componenti Generali Filament ==========
        'general-navigation' => [
            'label' => '🧭 Generale - Navigazione',
            'description' => 'Sidebar e navigazione principale',
            'css' => '',
            'selectors' => [
                '.fi-sidebar',
                '.fi-sidebar-nav',
                '.fi-sidebar-nav-item',
                '.fi-main-nav'
            ]
        ],
        'general-cards' => [
            'label' => '🃏 Generale - Card e Pannelli',
            'description' => 'Card, pannelli e sezioni generali',
            'css' => '',
            'selectors' => [
                '.fi-section',
                '.fi-card',
                '.fi-panel',
                '.fi-main-section'
            ]
        ],
        'general-header' => [
            'label' => '🎯 Generale - Header e Topbar',
            'description' => 'Header principale e topbar',
            'css' => '',
            'selectors' => [
                '.fi-header',
                '.fi-topbar',
                '.fi-main-header',
                '.fi-page-header'
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
        try {
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
            
            // Notifica di successo
            Notification::make()
                ->title('🎨 Tema personalizzato salvato!')
                ->body('Ricaricamento in corso...')
                ->success()
                ->send();
                
            // Approccio diretto con JavaScript - più affidabile
            $this->js('
                setTimeout(() => {
                    console.log("Ricaricamento forzato dal PHP...");
                    window.location.reload();
                }, 1000);
            ');
            
        } catch (\Exception $e) {
            Notification::make()
                ->title('Errore nel salvataggio del tema')
                ->body($e->getMessage())
                ->danger()
                ->send();
        }
    }
    
    private function generateFilamentCss(array $styles, string $cssPath): void
    {
        $css = "/* Filament Custom Theme - Global Application */\n";
        $css .= "/* Generated following Filament best practices */\n";
        $css .= "/* https://filamentphp.com/docs/4.x/styling/css-hooks */\n";
        $css .= "/* Applies to ALL components in ALL panels */\n\n";
        
        foreach ($styles as $key => $cssRules) {
            if (empty($cssRules)) continue;
            
            $component = $this->componentStyles[$key];
            $css .= "/* {$component['label']} - {$component['description']} */\n";
            
            // Crea selettori con alta specificità per sovrascrivere gli stili di default
            $enhancedSelectors = [];
            foreach ($component['selectors'] as $selector) {
                // Applica globalmente con alta specificità
                $enhancedSelectors[] = "body.fi-body {$selector}";
                $enhancedSelectors[] = ".fi-main {$selector}";
                $enhancedSelectors[] = ".fi-page {$selector}";
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
                'forms-inputs' => 'background-color: #374151; border-color: #6b7280; color: #f9fafb;',
                'forms-buttons' => 'background-color: #1f2937; border-color: #374151; color: #f9fafb;',
                'general-cards' => 'background-color: #1f2937; border-color: #374151;'
            ],
            'colorful' => [
                'forms-inputs' => 'background-color: #fef3c7; border: 2px solid #f59e0b; border-radius: 8px;',
                'forms-buttons' => 'background: linear-gradient(45deg, #3b82f6, #8b5cf6); color: white; border-radius: 8px;',
                'general-cards' => 'background: linear-gradient(135deg, #f3f4f6, #e5e7eb); border-radius: 12px;'
            ],
            'minimal' => [
                'forms-inputs' => 'border: 1px solid #e5e7eb; border-radius: 4px; box-shadow: none;',
                'forms-buttons' => 'border-radius: 4px; box-shadow: none; border: 1px solid #d1d5db;',
                'general-cards' => 'border: 1px solid #e5e7eb; border-radius: 6px; box-shadow: none;'
            ]
        ];
        
        if (isset($presets[$presetName])) {
            foreach ($presets[$presetName] as $key => $css) {
                if (isset($this->componentStyles[$key])) {
                    $this->componentStyles[$key]['css'] = $css;
                }
            }
            
            // Salva e ricarica con lo stesso meccanismo
            $this->saveStyles();
        }
    }
    
    public function getPreviewComponents(): array
    {
        return [
            'forms-inputs' => [
                'html' => '<input type="text" class="fi-input fi-fo-text-input" placeholder="Esempio input text" value="Testo di esempio">',
                'label' => 'Input Text'
            ],
            'forms-textarea' => [
                'html' => '<textarea class="fi-input fi-fo-textarea" rows="3" placeholder="Esempio textarea">Contenuto della textarea di esempio</textarea>',
                'label' => 'Textarea'
            ],
            'forms-buttons' => [
                'html' => '<button type="submit" class="fi-btn fi-fo-btn-primary">Salva Modifiche</button>',
                'label' => 'Pulsante Form'
            ],
            'actions-buttons-create' => [
                'html' => '<button class="fi-btn fi-ac-btn-create">+ Crea Nuovo</button>',
                'label' => 'Pulsante Crea'
            ],
            'actions-buttons-edit' => [
                'html' => '<button class="fi-btn fi-ac-btn-edit">✏️ Modifica</button>',
                'label' => 'Pulsante Modifica'
            ],
            'actions-buttons-delete' => [
                'html' => '<button class="fi-btn fi-ac-btn-delete">🗑️ Elimina</button>',
                'label' => 'Pulsante Elimina'
            ],
            'general-cards' => [
                'html' => '<div class="fi-card fi-section"><div class="p-4"><h3>Card di Esempio</h3><p>Contenuto della card per vedere l\'anteprima degli stili.</p></div></div>',
                'label' => 'Card/Pannello'
            ],
            'tables-main' => [
                'html' => '<div class="fi-ta-table"><table class="fi-table"><thead><tr class="fi-ta-header-row"><th class="fi-ta-header-cell">Nome</th><th class="fi-ta-header-cell">Email</th></tr></thead><tbody><tr class="fi-ta-row"><td class="fi-ta-cell">Mario Rossi</td><td class="fi-ta-cell">mario@example.com</td></tr></tbody></table></div>',
                'label' => 'Tabella'
            ],
            'notifications-base' => [
                'html' => '<div class="fi-no-notification"><div class="fi-no-notification-body">✅ Operazione completata con successo!</div></div>',
                'label' => 'Notifica'
            ]
        ];
    }
    
    public function previewStyle(string $componentKey): string
    {
        $component = $this->componentStyles[$componentKey] ?? null;
        if (!$component || empty($component['css'])) {
            return '';
        }
        
        // Genera CSS per l'anteprima
        $css = "<style>\n";
        $selectors = implode(', ', $component['selectors']);
        $css .= ".preview-container {$selectors} {\n";
        $css .= "    {$component['css']}\n";
        $css .= "}\n";
        $css .= "</style>\n";
        
        return $css;
    }
}
