<?php

namespace App\Filament\Host\Resources\Coworkings\Pages;

use App\Filament\Host\Resources\Coworkings\CoworkingResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Storage;
class EditCoworking extends EditRecord
{
    protected static string $resource = CoworkingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
   
   
   protected function afterSave(): void
{
    $state = $this->form->getState();
    logger()->info('Form state', $state);

    $tmpPaths = $state['images'] ?? [];

    logger()->info('TMP Paths:', $tmpPaths);

    if (!is_array($tmpPaths) || empty($tmpPaths)) {
        logger()->warning('Nessuna immagine da processare');
        return;
    }

    $coworkingId = $this->record->id;
    $newPaths = [];

    foreach ($tmpPaths as $path) {
        logger()->info('Analizzo path:', [$path]);

        if (str_starts_with($path, 'livewire-tmp/')) {
            $newPath = "coworkings/{$coworkingId}/" . basename($path);
            logger()->info("Sposto da $path a $newPath");
            Storage::disk('s3')->writeStream(
    $newPath,
    Storage::disk('s3')->readStream($path),
    ['visibility' => 'public']
);
Storage::disk('s3')->delete($path);
            
            
            $newPaths[] = $newPath;
        } else {
            $newPaths[] = $path;
        }
    }

    logger()->info('Nuovi path finali:', $newPaths);

    $this->record->update([
        'images' => $newPaths,
    ]);
}


    
}

