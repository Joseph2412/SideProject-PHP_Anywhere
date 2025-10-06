<?php

namespace App\Filament\Host\Resources\Bookings\Schemas;

use App\Models\Coworking;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\DateTimePicker;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;

class BookingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // Coworking (solo quelli dell'host loggato)
                Select::make('coworking_id')
                    ->label('Coworking')
                    ->options(function () {
                        return Coworking::where('host_id', Auth::id())
                            ->pluck('name', 'id');
                    })
                    ->required()
                    ->placeholder('Seleziona un coworking'),

                // Nome cliente
                TextInput::make('costumer_name')
                    ->label('Nome Cliente')
                    ->required()
                    ->placeholder('Inserisci il nome del cliente'),

                // Email cliente (opzionale)
                TextInput::make('costumer_email')
                    ->label('Email Cliente')
                    ->email()
                    ->placeholder('email@esempio.com (opzionale)'),
                    
                // Data prenotazione
                DatePicker::make('booking_date')
                    ->label('Data Prenotazione')
                    ->required()
                    ->minDate(now()->format('Y-m-d'))
                    ->displayFormat('d/m/Y'),
                    
                // Orario inizio
                TimePicker::make('start_time')
                    ->label('Ora Inizio')
                    ->required()
                    ->seconds(false)
                    ->minutesStep(15),
                    
                // Orario fine
                TimePicker::make('end_time')
                    ->label('Ora Fine')
                    ->required()
                    ->seconds(false)
                    ->minutesStep(15)
                    ->after('start_time'),
                
                TextInput::make("total_price")
                    ->label("Prezzo Totale (€)")
                    ->numeric()
                    ->minValue(0)
                    ->step(0.01)
                    ->prefix('€')
                    ->required(),

                // Numero ospiti (obbligatorio)
                TextInput::make('guests_count')
                    ->label('Numero Ospiti')
                    ->numeric()
                    ->minValue(1)
                    ->default(1)
                    ->required(),

                // Tipo prenotazione (obbligatorio)
                Select::make('booking_type')
                    ->label('Tipo Prenotazione')
                    ->options([
                        'hourly' => 'Oraria',
                        'daily' => 'Giornaliera',
                    ])
                    ->default('hourly')
                    ->required(),

                // Status prenotazione (obbligatorio)
                Select::make('status')
                    ->label('Stato')
                    ->options([
                        'pending' => 'In Attesa',
                        'confirmed' => 'Confermata',
                        'cancelled' => 'Cancellata',
                        'completed' => 'Completata',
                        'no_show' => 'Non Presentato',
                    ])
                    ->default('pending')
                    ->required(),

                // Payment status (obbligatorio)
                Select::make('payment_status')
                    ->label('Stato Pagamento')
                    ->options([
                        'pending' => 'In Attesa',
                        'paid' => 'Pagato',
                        'refunded' => 'Rimborsato',
                        'failed' => 'Fallito',
                    ])
                    ->default('pending')
                    ->required(),

                // Payment method (opzionale)
                Select::make('payment_method')
                    ->label('Metodo Pagamento')
                    ->options([
                        'cash' => 'Contanti',
                        'card' => 'Carta',
                        'bank_transfer' => 'Bonifico',
                        'paypal' => 'PayPal',
                    ])
                    ->placeholder('Seleziona metodo'),

                // Note (opzionale)
                Textarea::make('notes')
                    ->label('Note')
                    ->rows(3)
                    ->placeholder('Note aggiuntive'),

                // Special requests (opzionale)
                Textarea::make('special_requests')
                    ->label('Richieste Speciali')
                    ->rows(2)
                    ->placeholder('Richieste particolari'),

                // Cancellation reason (visibile solo se cancelled)
                Textarea::make('cancellation_reason')
                    ->label('Motivo Cancellazione')
                    ->rows(2)
                    ->visible(fn ($get) => $get('status') === 'cancelled'),

                // Cancelled at (visibile solo se cancelled)
                DateTimePicker::make('cancelled_at')
                    ->label('Data Cancellazione')
                    ->visible(fn ($get) => $get('status') === 'cancelled'),
            ]);
    }
}
