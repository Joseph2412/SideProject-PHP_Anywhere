# Advanced Filament Theme Designer

## 🎨 Overview

Il sistema Theme Designer è stato completamente rinnovato per supportare tutte le **Hook Class Abbreviations** di Filament v4 e permettere la personalizzazione granulare dei componenti sia globalmente che per panel specifici.

## 🏗️ Struttura del Sistema

### Hook Class Abbreviations Supportate

Seguendo le [specifiche ufficiali di Filament v4](https://filamentphp.com/docs/4.x/styling/css-hooks):

-   **fi** = Filament
-   **fi-ac** = Actions package
-   **fi-fo** = Forms package
-   **fi-in** = Infolists package
-   **fi-no** = Notifications package
-   **fi-sc** = Schema/Components package
-   **fi-ta** = Tables package
-   **fi-wi** = Widgets package

### Abbreviazioni Comuni

-   **btn** = button
-   **col** = column
-   **ctn** = container
-   **wrp** = wrapper

## 🎯 Targeting dei Panel

### Modalità di Targeting

1. **🌐 Tutti i Panel** - Applica a admin e host panel
2. **👨‍💼 Admin Panel** - Solo per il panel admin
3. **🏠 Host Panel** - Solo per il panel host

### Come Funziona

Il sistema genera selettori CSS specifici per ogni modalità:

```css
/* Targeting Globale */
.fi-main .fi-btn,
.fi-page .fi-btn,
body.fi-body .fi-btn {
}

/* Targeting Admin Panel */
#admin .fi-btn,
[data-panel-id="admin"] .fi-btn {
}

/* Targeting Host Panel */
#host .fi-btn,
[data-panel-id="host"] .fi-btn {
}
```

## 🧩 Componenti Supportati

### Actions Package (fi-ac)

-   **Pulsanti Base** - `.fi-ac-btn`, `.fi-ac-btn-primary`
-   **Pulsanti Crea** - `.fi-ac-btn-create`
-   **Pulsanti Modifica** - `.fi-ac-btn-edit`
-   **Pulsanti Elimina** - `.fi-ac-btn-delete`
-   **Pulsanti Visualizza** - `.fi-ac-btn-view`
-   **Contenitori** - `.fi-ac-ctn`, `.fi-ac-wrp`

### Forms Package (fi-fo)

-   **Input Base** - `.fi-fo-text-input .fi-input`
-   **Textarea** - `.fi-fo-textarea .fi-input`
-   **Checkbox** - `.fi-fo-checkbox .fi-checkbox-input`
-   **Radio Button** - `.fi-fo-radio .fi-radio-input`
-   **Toggle/Switch** - `.fi-fo-toggle .fi-toggle-input`
-   **File Upload** - `.fi-fo-file-upload`
-   **Rich Editor** - `.fi-fo-rich-editor`

### Tables Package (fi-ta)

-   **Tabelle** - `.fi-ta-table`
-   **Righe** - `.fi-ta-row`, `.fi-ta-header-row`
-   **Celle** - `.fi-ta-cell`, `.fi-ta-header-cell`
-   **Colonne** - `.fi-ta-col`, `.fi-ta-column`
-   **Pulsanti Tabelle** - `.fi-ta-btn`

### Altri Package

-   **Notifications (fi-no)** - Toast, notifiche, pulsanti notifiche
-   **Infolists (fi-in)** - Contenitori, entries
-   **Schema (fi-sc)** - Contenitori e wrapper componenti
-   **Widgets (fi-wi)** - Contenitori e wrapper widget

## 👁️ Sistema di Preview

### Anteprima in Tempo Reale

Ogni componente supportato mostra un'anteprima live che si aggiorna automaticamente mentre scrivi il CSS:

-   **Input Text** - Mostra come appariranno i campi di testo
-   **Textarea** - Anteprima delle aree di testo
-   **Pulsanti** - Preview dei diversi tipi di pulsanti
-   **Tabelle** - Struttura di esempio delle tabelle
-   **Card/Pannelli** - Esempio di card e sezioni

### JavaScript Live Update

```javascript
// Aggiornamento automatico della preview
document.addEventListener("input", function (e) {
    if (e.target.matches('textarea[wire\\:model\\.defer*="componentStyles"]')) {
        // Applica CSS alla preview in tempo reale
    }
});
```

## ⚡ Preset Veloci

### Preset Disponibili

1. **🌙 Dark Mode** - Stili ottimizzati per modalità scura
2. **🌈 Colorful** - Tema colorato con gradienti
3. **⚪ Minimal** - Design minimalista e pulito

### Personalizzazione Preset

I preset possono essere facilmente estesi nel metodo `applyPreset()`:

```php
public function applyPreset(string $presetName): void
{
    $presets = [
        'custom-preset' => [
            'forms-inputs' => 'background: #custom; border: 1px solid #color;',
            'actions-buttons' => 'background: linear-gradient(45deg, #color1, #color2);'
        ]
    ];
}
```

## 🏗️ Architettura del Sistema

### File Principali

1. **ThemeDesignerPage.php** - Controller principale con logica
2. **global-theme-designer.blade.php** - Vista con UI organizzata
3. **FilamentThemeOverrideServiceProvider.php** - Injection CSS
4. **InjectFilamentCustomTheme.php** - Middleware injection

### Flusso di Salvataggio

1. **Editing** - L'utente modifica CSS nell'interfaccia
2. **Salvataggio** - Chiamata `saveStyles()` genera JSON e CSS
3. **Targeting** - CSS viene generato con selettori specifici per panel
4. **Injection** - Il CSS viene iniettato nelle pagine Filament
5. **Preview** - Aggiornamento live dell'anteprima

## 🔧 Utilizzo Avanzato

### Selettori Personalizzati

Puoi aggiungere facilmente nuovi componenti:

```php
'custom-component' => [
    'label' => '🎯 Componente Custom',
    'description' => 'Descrizione del componente',
    'css' => '',
    'selectors' => [
        '.fi-custom-selector',
        '.custom-class'
    ]
]
```

### Hook Classes Personalizzate

Il sistema supporta qualsiasi hook class di Filament:

```css
/* Esempi di hook classes avanzate */
.fi-fo-fieldset .fi-fieldset-header {
}
.fi-ta-bulk-actions .fi-bulk-action-btn {
}
.fi-no-notification-title {
}
```

## 📝 Best Practices

1. **Utilizza le Hook Classes** - Segui sempre le convenzioni ufficiali
2. **Testa Multi-Panel** - Verifica su admin e host panel
3. **Preview Prima di Salvare** - Usa l'anteprima per validare
4. **Specificità CSS** - Il sistema aggiunge automaticamente `!important`
5. **Modalità Scura** - Testa sempre light e dark mode

## 🚀 Funzionalità Future

-   [ ] Export/Import di temi
-   [ ] Condivisione temi tra progetti
-   [ ] Temi predefiniti per settori specifici
-   [ ] Editor visuale drag & drop
-   [ ] Integrazione con CSS frameworks

---

## 💡 Note Tecniche

Il sistema è completamente compatibile con Filament v4 e segue le migliori pratiche per la personalizzazione dei temi. Ogni modifica viene applicata con alta specificità CSS per garantire che gli stili personalizzati abbiano precedenza su quelli di default.
