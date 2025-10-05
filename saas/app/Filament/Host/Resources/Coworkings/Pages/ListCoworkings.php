<?php

namespace App\Filament\Host\Resources\Coworkings\Pages;

use App\Filament\Host\Resources\Coworkings\CoworkingResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCoworkings extends ListRecords
{
    protected static string $resource = CoworkingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
