# Global Filament Theme Designer

## 🎨 Overview

Il sistema Theme Designer è stato semplificato per fornire **personalizzazione globale** di tutti i componenti Filament. Le modifiche si applicano automaticamente a TUTTI i componenti del progetto, indipendentemente dal panel, tabella, card o contenitore in cui si trovano.

## 🌐 Applicazione Globale

### Filosofia del Design

-   ✅ **Un tema, ovunque** - Le modifiche si applicano universalmente
-   ✅ **Massima copertura** - Include componenti dentro tabelle, pannelli, modal
-   ✅ **Alta specificità** - CSS con priorità massima per sovrascrivere stili default
-   ✅ **Semplicità** - Nessuna configurazione per panel, tutto globale

### Selettori Estesi

Ogni componente ora include selettori per tutte le posizioni possibili:

```css
/* Esempio: Input Forms */
.fi-fo-text-input .fi-input,        /* Nei form standard */
.fi-ta-table .fi-input,             /* Dentro le tabelle */
.fi-section .fi-input,              /* Dentro le sezioni */
.fi-card .fi-input,                 /* Dentro le card */
.fi-panel .fi-input,                /* Dentro i pannelli */
.fi-modal .fi-input,                /* Dentro i modal */
input[type="text"]; /* Tutti gli input text */
```

## 🧩 Componenti Estesi

### Forms Package (fi-fo) - Copertura Completa

#### Input Base

-   **Posizioni**: Form standard, tabelle, sezioni, card, pannelli, modal
-   **Tipi**: Text, email, password, number
-   **Selettori**: `.fi-input`, `input[type="text"]`, etc.

#### Componenti Specifici

-   **Textarea** - Tutte le aree di testo ovunque
-   **Checkbox** - Tutte le checkbox in ogni contenitore
-   **Radio Button** - Tutti i radio button
-   **Toggle/Switch** - Tutti gli interruttori
-   **File Upload** - Componenti upload file
-   **Rich Editor** - Editor di testo ricco

### Actions Package (fi-ac) - Pulsanti Universali

#### Pulsanti Base

```css
.fi-btn,                    /* Pulsanti base */
/* Pulsanti base */
.fi-ta-table .fi-btn,       /* Pulsanti nelle tabelle */
.fi-section .fi-btn,        /* Pulsanti nelle sezioni */
.fi-card .fi-btn,           /* Pulsanti nelle card */
.fi-panel .fi-btn,          /* Pulsanti nei pannelli */
.fi-modal .fi-btn; /* Pulsanti nei modal */
```

#### Pulsanti Specifici per Azione

-   **Create** - `[wire:click*="create"]` ovunque
-   **Edit** - `[wire:click*="edit"]` ovunque
-   **Delete** - `[wire:click*="delete"]` ovunque
-   **View** - `[wire:click*="view"]` ovunque

### Tables Package (fi-ta) - Tabelle Complete

-   **Struttura principale** - `.fi-ta-table`
-   **Righe** - `.fi-ta-row`, `.fi-ta-header-row`
-   **Celle** - `.fi-ta-cell`, `.fi-ta-header-cell`
-   **Colonne** - `.fi-ta-col`, `.fi-ta-column`
-   **Pulsanti tabelle** - `.fi-ta-btn`

### Altri Package

#### Notifications (fi-no)

-   Toast e notifiche globali
-   Pulsanti all'interno delle notifiche

#### Infolists (fi-in)

-   Contenitori e voci delle infolists
-   Entries e sezioni informative

#### Schema/Components (fi-sc)

-   Contenitori dei componenti schema
-   Wrapper generici

#### Widgets (fi-wi)

-   Contenitori e wrapper dei widget
-   Componenti dashboard

## 🎯 Generazione CSS Ottimizzata

### Strategia di Specificità

Il sistema genera CSS con alta specificità per garantire che gli stili personalizzati abbiano sempre precedenza:

```css
/* Generazione automatica */
body.fi-body .fi-input,
.fi-main .fi-input,
.fi-page .fi-input,
.fi-input {
    background-color: #custom !important;
    border: 1px solid #color !important;
}
```

### Applicazione Universale

```php
// Nel generateFilamentCss()
$enhancedSelectors = [];
foreach ($component['selectors'] as $selector) {
    $enhancedSelectors[] = "body.fi-body {$selector}";
    $enhancedSelectors[] = ".fi-main {$selector}";
    $enhancedSelectors[] = ".fi-page {$selector}";
    $enhancedSelectors[] = $selector;
}
```

## ⚡ Preset Veloci Aggiornati

### Preset Disponibili

1. **🌙 Dark Mode** - Stili scuri universali
2. **🌈 Colorful** - Tema colorato globale
3. **⚪ Minimal** - Design minimalista

### Applicazione Preset

I preset ora si applicano automaticamente a tutti i componenti corrispondenti:

```php
'dark-mode' => [
    'forms-inputs' => 'background-color: #374151; border-color: #6b7280; color: #f9fafb;',
    'forms-buttons' => 'background-color: #1f2937; border-color: #374151; color: #f9fafb;',
    'general-cards' => 'background-color: #1f2937; border-color: #374151;'
]
```

## 👁️ Preview Live Migliorato

### Componenti di Anteprima

Ogni categoria include esempi HTML rappresentativi:

-   **Input Text** - Input di esempio con placeholder
-   **Textarea** - Area di testo multiriga
-   **Pulsanti** - Diversi tipi di pulsanti (create, edit, delete)
-   **Tabelle** - Struttura tabella completa
-   **Card/Pannelli** - Esempio di contenitori
-   **Notifiche** - Toast di esempio

### JavaScript Live Update

```javascript
// Aggiornamento automatico
document.addEventListener("input", function (e) {
    if (e.target.matches('textarea[wire\\:model\\.defer*="componentStyles"]')) {
        // Applica CSS alla preview in tempo reale
        const css = e.target.value;
        const style = document.createElement("style");
        style.innerHTML = `.preview-${key} * { ${css} }`;
        document.head.appendChild(style);
    }
});
```

## 🏗️ Architettura Semplificata

### File Principali

1. **ThemeDesignerPage.php** - Controller semplificato senza targeting panel
2. **global-theme-designer.blade.php** - Vista con organizzazione per categorie
3. **FilamentThemeOverrideServiceProvider.php** - Injection CSS globale
4. **InjectFilamentCustomTheme.php** - Middleware universal injection

### Flusso Semplificato

1. **Editing** - Modifica CSS nell'interfaccia
2. **Salvataggio** - Genera JSON e CSS globale
3. **Injection** - CSS iniettato in tutte le pagine Filament
4. **Applicazione** - Stili applicati universalmente

## 📝 Best Practices

### Principi Guida

1. **Semplicità** - Un tema, ovunque applicato
2. **Consistenza** - Stili uniformi in tutto il progetto
3. **Specificità** - CSS con priorità massima
4. **Copertura** - Include tutti i possibili contenitori
5. **Performance** - Selettori ottimizzati

### Utilizzo Ottimale

```css
/* Buona pratica - Stili globali */
background-color: #f3f4f6;
border: 2px solid #3b82f6;
border-radius: 8px;
padding: 8px;

/* Evitare - Selettori troppo specifici (non necessari) */
/* Il sistema gestisce automaticamente la specificità */
```

## 🚀 Vantaggi del Sistema Globale

### Pro

-   ✅ **Semplicità** - Un'unica configurazione per tutto
-   ✅ **Consistenza** - Design uniforme ovunque
-   ✅ **Efficienza** - Nessuna duplicazione di configurazione
-   ✅ **Completezza** - Copre tutti i componenti possibili
-   ✅ **Manutenibilità** - Facile da gestire e aggiornare

### Esempi d'Uso

```css
/* Personalizzazione globale input */
background: linear-gradient(45deg, #f0f9ff, #dbeafe);
border: 2px solid #3b82f6;
border-radius: 12px;
transition: all 0.3s ease;

/* Si applica automaticamente a:
- Input nei form standard
- Input nelle tabelle
- Input nelle card
- Input nei pannelli
- Input nei modal
- Tutti gli input text del progetto */
```

---

## 💡 Note Tecniche

Il sistema è ora **completamente globale** e applica automaticamente gli stili a tutti i componenti Filament del progetto, garantendo massima semplicità d'uso e consistenza visiva universale. 🎨✨
