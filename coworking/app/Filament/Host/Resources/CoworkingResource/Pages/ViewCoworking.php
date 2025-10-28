<?php

namespace App\Filament\Host\Resources\CoworkingResource\Pages;

use App\Filament\Host\Resources\CoworkingResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewCoworking extends ViewRecord
    

{
    protected static string $resource = CoworkingResource::class;

    protected function getActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\Action::make('backToList')
                ->label('Ritorna alla Lista')
                ->url(fn () => static::getResource()::getUrl('index')),
        ];
    }
}
