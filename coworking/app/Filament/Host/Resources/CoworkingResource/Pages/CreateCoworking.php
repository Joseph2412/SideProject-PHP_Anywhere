<?php

namespace App\Filament\Host\Resources\CoworkingResource\Pages;

use App\Filament\Host\Resources\CoworkingResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateCoworking extends CreateRecord
{
    protected static string $resource = CoworkingResource::class;

    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('view', ['record' => $this->record]);
    }




    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['host_id'] = Auth::id();

        return $data;
    }
}
