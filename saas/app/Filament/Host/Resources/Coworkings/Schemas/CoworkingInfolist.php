<?php

namespace App\Filament\Host\Resources\Coworkings\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Schemas\Components\Fieldset;
use Illuminate\Support\Facades\Storage;

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

                Fieldset::make('Galleria Immagini')
                    ->schema([
                        TextEntry::make('images')
                            ->label('')
                            ->formatStateUsing(function ($state, $record) {
                                if (!$state || !is_array($state) || empty($state)) {
                                    return 'Nessuna immagine caricata';
                                }
                                
                                $html = '<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">';
                                foreach ($state as $imagePath) {
                                    // Costruisci URL S3 manualmente se necessario
                                    $bucket = config('filesystems.disks.s3.bucket');
                                    $region = config('filesystems.disks.s3.region');
                                    $imageUrl = "https://{$bucket}.s3.{$region}.amazonaws.com/{$imagePath}";
                                    
                                    $html .= '<div class="aspect-square">
                                        <img src="' . $imageUrl . '" 
                                             class="w-full h-full object-cover rounded-lg border border-gray-200" 
                                             alt="Immagine coworking" 
                                             style="max-height: 200px;" />
                                    </div>';
                                }
                                $html .= '</div>';
                                
                                return $html;
                            })
                            ->html()
                            ->columnSpanFull(),
                    ])
            ]);
                
    }
}
