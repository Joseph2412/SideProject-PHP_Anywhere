# 🎨 Filament Theme Designer - Pacchetto di Integrazione

## 📋 Panoramica

Questo pacchetto contiene tutti i file necessari per integrare il **Theme Designer** in qualsiasi progetto Filament v3.2+. Permette di personalizzare facilmente tutti i componenti Filament tramite un'interfaccia web intuitiva.

## 🎯 Funzionalità

- ✅ **Personalizzazione globale** di tutti i componenti Filament
- ✅ **Hook Classes** complete secondo le specifiche Filament v4
- ✅ **Anteprima live** delle modifiche
- ✅ **Preset veloci** (Dark Mode, Colorful, Minimal)
- ✅ **Persistenza** automatica dei temi
- ✅ **Alta specificità CSS** con `!important` automatico

## 📁 File Essenziali per l'Integrazione

```
app/
├── Filament/
│   └── Pages/
│       └── ThemeDesignerPage.php ✅ Controller principale
└── Providers/
    └── FilamentThemeOverrideServiceProvider.php ✅ CSS Injection

resources/
└── views/
    └── filament/
        └── pages/
            └── global-theme-designer.blade.php ✅ Interfaccia UI
```

## ⚡ Installazione Rapida

### 1. Copia i file
Copia i 3 file essenziali nella struttura corrispondente del tuo progetto.

### 2. Registra il Service Provider
Aggiungi in `bootstrap/providers.php`:

```php
<?php

return [
    App\Providers\AppServiceProvider::class,
    App\Providers\FilamentThemeOverrideServiceProvider::class, // ⬅️ AGGIUNGI QUESTA RIGA
];
```

**O** in `config/app.php` (Laravel 10 e precedenti):
```php
'providers' => [
    // ... altri providers
    App\Providers\FilamentThemeOverrideServiceProvider::class,
],
```

### 3. Aggiungi la Page al tuo Panel Provider
Nel tuo `AdminPanelProvider.php` (o altro panel):

```php
use App\Filament\Pages\ThemeDesignerPage;

public function panel(Panel $panel): Panel
{
    return $panel
        // ... altre configurazioni
        ->pages([
            Pages\Dashboard::class,
            ThemeDesignerPage::class, // ⬅️ AGGIUNGI QUESTA RIGA
        ]);
}
```

### 4. Verifica dipendenze composer.json
Assicurati di avere:

```json
{
    "require": {
        "filament/filament": "^3.2"
    }
}
```

## 🚀 Test di Funzionamento

1. **Accedi al tuo panel Filament** (es. `/admin`)
2. **Vai su "Theme Designer"** nella sidebar
3. **Modifica alcuni CSS** (es. cambia colore dei pulsanti)
4. **Clicca "Salva Tema"**
5. **Verifica** che gli stili si applichino immediatamente

## 📊 Componenti Supportati

Il Theme Designer copre **TUTTI** i componenti Filament principali:

- **🎬 Actions**: Pulsanti (create, edit, delete, view)
- **📝 Forms**: Input, textarea, checkbox, radio, toggle, file upload
- **📊 Tables**: Tabelle, righe, celle, colonne  
- **📋 Infolists**: Contenitori ed entries
- **🔔 Notifications**: Toast e notifiche
- **📈 Widgets**: Contenitori e wrapper
- **🧭 Layout**: Navigation, cards, header

## 🎨 Hook Classes Supportate

Segue le convenzioni ufficiali Filament v4:
- `fi-ac` = Actions package
- `fi-fo` = Forms package  
- `fi-ta` = Tables package
- `fi-in` = Infolists package
- `fi-no` = Notifications package
- `fi-wi` = Widgets package

## 💾 Persistenza

I temi vengono salvati in:
- `storage/app/filament-custom-theme.json` (configurazione)
- `storage/app/filament-custom-theme.css` (CSS generato)

## 🔧 Risoluzione Problemi

### Tema non si applica
1. Verifica che il `FilamentThemeOverrideServiceProvider` sia registrato
2. Controlla i permessi di scrittura su `storage/app/`
3. Pulisci la cache: `php artisan filament:cache-components`

### Page non appare
1. Verifica che `ThemeDesignerPage::class` sia nella lista `pages()`
2. Controlla che non ci siano conflitti di route
3. Pulisci la cache config: `php artisan config:clear`

## 📖 Documentazione

Per maggiori dettagli sui componenti supportati e personalizzazioni avanzate, consulta:
- [Documentazione Hook Classes Filament](https://filamentphp.com/docs/4.x/styling/css-hooks)
- Codice sorgente in `ThemeDesignerPage.php`

---

**🎯 Sviluppato per Filament v3.2+ | Testato su Laravel 11**