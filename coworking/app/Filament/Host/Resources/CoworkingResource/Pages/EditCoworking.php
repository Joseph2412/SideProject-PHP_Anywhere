<?php

namespace App\Filament\Host\Resources\CoworkingResource\Pages;

use App\Filament\Host\Resources\CoworkingResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCoworking extends EditRecord
{
    protected static string $resource = CoworkingResource::class;
    
    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('view', ['record' => $this->record]);
    }
}
