<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ScanFilamentComponentsCommand extends Command
{
    protected $signature = 'filament:scan';
    protected $description = 'Scansiona il progetto e rileva i componenti Filament utilizzati.';

    public function handle(): int
{
    // 1️⃣ Evita timeout
    ini_set('max_execution_time', 300); // fino a 5 minuti

    $this->info('🔍 Scansione in corso dei componenti Filament...');

    // 2️⃣ Directory da scansionare (ridotte per velocità)
    $directories = [
        app_path('Filament'),
        resource_path('views'),
    ];

    $results = [];

    foreach ($directories as $dir) {
        $files = File::allFiles($dir);

        // 3️⃣ Progress bar
        $total = count($files);
        $progress = $this->output->createProgressBar($total);
        $progress->start();

        // 4️⃣ Ciclo su tutti i file
        foreach ($files as $file) {
            $content = File::get($file->getRealPath());

            preg_match_all(
                '/([A-Z][A-Za-z0-9]+)::make\s*\(\s*[\'"]([^\'"]+)[\'"]\s*\)/',
                $content,
                $matches,
                PREG_SET_ORDER
            );

            foreach ($matches as $match) {
                $results[] = [
                    'component' => $match[1],
                    'field' => $match[2],
                    'file' => str_replace(base_path() . '/', '', $file->getRealPath()),
                ];
            }

            $progress->advance();
        }

        $progress->finish();
        $this->newLine();
    }

    // 5️⃣ Salva il file JSON
    $outputPath = storage_path('app/filament-components.json');
    File::put($outputPath, json_encode($results, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

    // 6️⃣ Messaggi finali
    $this->info("\n✅ Scansione completata.");
    $this->info('📁 File salvato in: ' . $outputPath);
    $this->info('🧩 Componenti trovati: ' . count($results));

    return self::SUCCESS;
}
}