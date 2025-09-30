<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

## PHP Anywhere - SideProject

### Descrizione sintetica

Applicazione SaaS in PHP/Laravel con dashboard Filament per due tipi di utenti:

-   **Admin**: gestisce utenti, venue, annunci, abbonamenti.
-   **Host**: gestisce solo i propri venue, servizi, foto, abbonamenti.

---

## Comandi utili

### Comandi Laravel Artisan

-   **php artisan serve**
    Avvia il server locale di sviluppo Laravel (di default su http://localhost:8000).
-   **php artisan migrate**
    Esegue tutte le migrazioni del database, creando/modificando tabelle secondo le migration presenti.
-   **php artisan migrate:rollback**
    Annulla l'ultima migrazione eseguita, utile per tornare indietro se una migration ha problemi.
-   **php artisan make:migration nome_migration**
    Crea un nuovo file di migration per modificare la struttura del database.
-   **php artisan make:model NomeModello**
    Crea un nuovo model Eloquent (rappresenta una tabella del database).
-   **php artisan make:controller NomeController**
    Crea un nuovo controller per gestire la logica delle richieste HTTP.
-   **php artisan make:policy NomePolicy**
    Crea una nuova policy per gestire le autorizzazioni su un model.
-   **php artisan make:factory NomeFactory**
    Crea una factory per generare dati fittizi (utile nei test e nei seeders).
-   **php artisan make:seeder NomeSeeder**
    Crea un seeder per popolare il database con dati di esempio.
-   **php artisan db:seed**
    Esegue tutti i seeder per popolare il database.
-   **php artisan tinker**
    Avvia una console interattiva (REPL) per eseguire comandi PHP direttamente sull'applicazione.

### Comandi Filament

-   **php artisan make:filament-resource NomeResource**
    Crea una nuova resource Filament (CRUD per un model, con tabella e form).
-   **php artisan make:filament-panel nome_panel**
    Crea un nuovo pannello Filament (dashboard separata, es. per Admin o Host).
-   **php artisan make:filament-page NomePage**
    Crea una nuova pagina personalizzata Filament.
-   **php artisan make:filament-widget NomeWidget**
    Crea un nuovo widget Filament (elemento dashboard, es. statistiche).

### Comandi Composer

-   **composer install**
    Installa tutte le dipendenze PHP definite in composer.json.
-   **composer update**
    Aggiorna tutte le dipendenze PHP all'ultima versione compatibile.
-   **composer require vendor/nome-pacchetto**
    Aggiunge e installa un nuovo pacchetto PHP.
-   **composer remove vendor/nome-pacchetto**
    Rimuove un pacchetto PHP dal progetto.

---

## Note

-   Modifica il file `.env` per configurare database, mail, S3, ecc.
-   Consulta il file `Journal.md` per lo stato e la roadmap del progetto.

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

-   [Simple, fast routing engine](https://laravel.com/docs/routing).
-   [Powerful dependency injection container](https://laravel.com/docs/container).
-   Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
-   Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
-   Database agnostic [schema migrations](https://laravel.com/docs/migrations).
-   [Robust background job processing](https://laravel.com/docs/queues).
-   [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

-   **[Vehikl](https://vehikl.com)**
-   **[Tighten Co.](https://tighten.co)**
-   **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
-   **[64 Robots](https://64robots.com)**
-   **[Curotec](https://www.curotec.com/services/technologies/laravel)**
-   **[DevSquad](https://devsquad.com/hire-laravel-developers)**
-   **[Redberry](https://redberry.international/laravel-development)**
-   **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
