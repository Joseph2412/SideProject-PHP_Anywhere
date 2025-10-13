<?php

namespace App\Filament\Host\Resources\Coworkings\Pages;

use App\Filament\Host\Resources\Coworkings\CoworkingResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CreateCoworking extends CreateRecord
{
    protected static string $resource = CoworkingResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $userId = Auth::id();
        
        $data["host_id"] = $userId;

        return $data;
    }

    protected function afterCreate(): void
{
    $tmpPaths = $this->form->getState()['images'] ?? [];

    if (!is_array($tmpPaths) || empty($tmpPaths)) {
        return;
    }

    $coworkingId = $this->record->id;
    $newPaths = [];

    foreach ($tmpPaths as $tmpPath) {
        $newPath = "coworkings/{$coworkingId}/" . basename($tmpPath);
        Storage::disk('s3')->move($tmpPath, $newPath);
        $newPaths[] = $newPath;
    }

    $this->record->update([
        'images' => $newPaths,
    ]);
}


      protected function getRedirectUrl(): string
    {
        return CoworkingResource::getUrl('index');
    }


}
