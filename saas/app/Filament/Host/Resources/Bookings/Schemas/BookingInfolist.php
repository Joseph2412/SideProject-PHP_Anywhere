<?php

namespace App\Filament\Host\Resources\Bookings\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class BookingInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                TextEntry::make("coworking.name")
                    ->label('Coworking'),

                TextEntry::make('costumer_name')
                    ->label('Nome Cliente'),
                
                TextEntry::make('booking_date')
                    ->label('Data Prenotazione')
                    ->date('d/m/Y'),

                TextEntry::make('start_time')
                    ->label('Inizio Prenotazione')
                    ->time('H:i'),
                
                TextEntry::make('end_time')
                    ->label('Fine Prenotazione')
                    ->time('H:i'),

                TextEntry::make('guests_count')
                    ->label('Numero Ospiti'),

                TextEntry::make('booking_type')
                    ->label('Tipologia Prenotazione')
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'hot_desk' => 'Postazione Condivisa',
                        'meeting_room' => 'Sala Riunioni',
                        'private_office' => 'Ufficio Privato',
                        default => $state,
                    }),

                TextEntry::make('total_price')
                    ->label('Prezzo Totale')    
                    ->prefix('€'),
                
                
            ]);
    }
}
