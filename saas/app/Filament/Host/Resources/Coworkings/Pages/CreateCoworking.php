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

    /** @noinspection PhpUndefinedFieldInspection */
    protected function afterCreate(): void
    {
        
        $record = $this->record; // Record appena creato

    $tempPath = "coworkings/temp";
    $finalPath = "coworkings/images/{$record->id}";

    $disk = Storage::disk('s3');

    foreach ($disk->files($tempPath) as $file) {
        $newPath = str_replace($tempPath, $finalPath, $file);
        $disk->move($file, $newPath);
    }
}



      protected function getRedirectUrl(): string
    {
        return CoworkingResource::getUrl('index');
    }


}
