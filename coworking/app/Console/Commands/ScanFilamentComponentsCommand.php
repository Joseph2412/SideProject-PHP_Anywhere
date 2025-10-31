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
        $this->info('🔍 Scansione in corso dei componenti Filament...');

        // Directory da scansionare
        $directories = [
            app_path(),
            resource_path('views'),
        ];

        $results = [];

        foreach ($directories as $dir) {
            $files = File::allFiles($dir);

            foreach ($files as $file) {
                $content = File::get($file->getRealPath());

                // Regex che intercetta pattern tipo TextInput::make('...')
                preg_match_all('/([A-Z][A-Za-z0-9]+)::make\s*\(\s*[\'"]([^\'"]+)[\'"]\s*\)/', $content, $matches, PREG_SET_ORDER);

                foreach ($matches as $match) {
                    $results[] = [
                        'component' => $match[1],
                        'field' => $match[2],
                        'file' => str_replace(base_path() . '/', '', $file->getRealPath()),
                    ];
                }
            }
        }

        // Salva i risultati in JSON
        $outputPath = storage_path('app/filament-components.json');
        File::put($outputPath, json_encode($results, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

        $this->info('✅ Scansione completata.');
        $this->info('📁 File salvato in: ' . $outputPath);
        $this->info('🧩 Componenti trovati: ' . count($results));

        return self::SUCCESS;
    }
}
