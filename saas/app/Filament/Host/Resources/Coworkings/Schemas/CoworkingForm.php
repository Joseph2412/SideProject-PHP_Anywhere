<?php

namespace App\Filament\Host\Resources\Coworkings\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Components\Fieldset;
use Illuminate\Support\Facades\Log;

class CoworkingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nome')
                    ->required(),
                Textarea::make('description')
                    ->label('Descrizione')
                    ->rows(3),
                TextInput::make('address')
                    ->label('Indirizzo')
                    ->required(),
                TextInput::make('city')
                    ->label('Città')
                    ->required(),
                TextInput::make('country')
                    ->label('Paese')
                    ->default('Italia')
                    ->required(),
                TextInput::make('amenities')
                    ->label('Servizi (separati da virgola)')
                    ->helperText('Esempio: WiFi, Parcheggio, Caffè'),
                Select::make('space_type')
                    ->label('Tipo di Spazio')
                    ->options([
                        'open_space' => 'Spazio Aperto',
                        'private_office' => 'Ufficio Privato',
                        'meeting_room' => 'Sala Riunioni',
                        'conference_room' => 'Sala Conferenze',
                        'hot_desk' => 'Postazione Condivisa',
                    ])
                    ->required(),
                TextInput::make('availability')
                    ->label('Disponibilità Oraria')
                    ->helperText('Esempio: Lun-Ven 9:00-18:00'),
                TextInput::make('capacity')
                    ->numeric()
                    ->label('Capacità Massima')
                    ->minValue(1)
                    ->step(1)
                    ->required(),
                TextInput::make('price_per_hour')
                    ->label('Prezzo per Ora (€)')
                    ->numeric()
                    ->minValue(0)
                    ->step(0.01),
                TextInput::make('price_per_day')
                    ->label('Prezzo per Giorno (€)')
                    ->numeric()
                    ->minValue(0)
                    ->step(0.01),
                Select::make('status')
                    ->label('Stato')
                    ->options([
                        'open' => 'Aperto',
                        'closed' => 'Chiuso',
                        'inactive' => 'Inattivo',
                    ])
                    ->default('inactive')
                    ->required(),

                Fieldset::make("Galleria Immagini")
                    ->schema([
                        FileUpload::make('images')
                            ->label('Galleria Immagini')
                            ->disk('s3')
                            ->directory('livewire-tmp')
                            ->preserveFilenames()
                            ->image()
                            ->multiple()
                            ->visibility('public')
                            ->previewable()
                            ->reorderable()
                            ->deletable()
                            
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                            ->maxSize(5120) // 5MB
                            ->maxFiles(10)
                            ->imagePreviewHeight('200')
                            ->panelAspectRatio('16:9')
                            ->panelLayout('integrated')
                            ->imageResizeMode('cover')
                            ->imageCropAspectRatio('16:9')
                            ->imageResizeTargetWidth('1200')
                            ->imageResizeTargetHeight('675')
                            ->columnSpanFull()
                            ->downloadable()
                            ->openable()
                            ->deletable()
                            ->deleteUploadedFileUsing(function ($file) {
                                Log::info('Tentativo di cancellazione file: ' . $file);
                                return false; 
                            }),
                    ])
            ]); 
    }
}
