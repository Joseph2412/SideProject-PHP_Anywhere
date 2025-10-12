<?php

namespace App\Filament\Host\Resources\Coworkings\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Schemas\Components\Fieldset;

class CoworkingInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name')
                    ->label('Nome'),

                TextEntry::make('city')
                    ->label('Città'),

                TextEntry::make('space_type')
                    ->label('Tipo di Spazio')
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'open_space' => 'Spazio Aperto',
                        'private_office' => 'Ufficio Privato',
                        'meeting_room' => 'Sala Riunioni',
                        'conference_room' => 'Sala Conferenze',
                        'hot_desk' => 'Postazione Condivisa',
                        default => $state,
                    }),

                TextEntry::make('capacity')
                    ->label('Capacità'),

                TextEntry::make('status')
                    ->label('Stato')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'open' => 'success',
                        'closed' => 'warning',
                        'inactive' => 'gray',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'open' => 'Aperto',
                        'closed' => 'Chiuso',
                        'inactive' => 'Inattivo',
                        default => $state,
                    }),

                TextEntry::make("amenities")
                    ->label("Servizi")
                    ->formatStateUsing(fn (string $state): string => str_replace(',', ', ', $state)),

                Fieldset::make('Gallery Immagini')
                    ->schema([
                        RepeatableEntry::make('images')
                            ->schema([
                                ImageEntry::make('path')
                                    ->label('')
                                    ->disk('s3')
                                    ->height(200)
                                    ->width(300),
                                TextEntry::make('caption')
                                    ->label('Descrizione')
                                    ->placeholder('Nessuna descrizione'),
                            ])
                            ->grid(3)
                            ->columns(1)
                    ])
            ]);
                
    }
}
