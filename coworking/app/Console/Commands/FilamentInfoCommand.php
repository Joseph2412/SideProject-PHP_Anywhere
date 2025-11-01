<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class FilamentInfoCommand extends Command
{
    protected $signature = 'filament:info';
    protected $description = 'Mostra la versione di Filament e il nome del progetto Laravel.';

    public function handle(): int
    {
        // Nome progetto (da .env o config/app.php)
        $projectName = config('app.name', 'Laravel');

        // Versione Filament installata
        $filamentVersion = \Composer\InstalledVersions::getPrettyVersion('filament/filament') ?? 'Sconosciuta';

        $this->info("📦 Progetto: {$projectName}");
        $this->info("🎨 Versione Filament: {$filamentVersion}");

        return self::SUCCESS;
    }
}
