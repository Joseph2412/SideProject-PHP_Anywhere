<?php

namespace App\Filament\Host\Resources\CoworkingResource\Pages;

use App\Filament\Host\Resources\CoworkingResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCoworkings extends ListRecords
{
    protected static string $resource = CoworkingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
