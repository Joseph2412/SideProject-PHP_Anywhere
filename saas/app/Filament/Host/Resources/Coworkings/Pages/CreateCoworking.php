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
}
