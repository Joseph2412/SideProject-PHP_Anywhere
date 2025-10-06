<?php

namespace App\Filament\Host\Resources\Bookings\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class BookingsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('costumer_name')
                    ->label('Nome Cliente')
                    ->searchable()
                    ->sortable(),
                TextColumn::make("booking_date")
                    ->label("Data Prenotazione")
                    ->date('d/m/Y')
                    ->searchable()
                    ->sortable(),
                TextColumn::make("start_time")
                    ->label("Ora Inizio")
                    ->time('H:i')
                    ->searchable()
                    ->sortable(),
                TextColumn::make("status")
                    ->label("Stato")
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pending' => 'In Attesa',
                        'confirmed' => 'Confermata',
                        'cancelled' => 'Cancellata',
                        'completed' => 'Completata',
                        default => $state,
                    })
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'confirmed' => 'success',
                        'cancelled' => 'danger',
                        'completed' => 'primary',
                        default => 'gray',
                    })
                    ->searchable()
                    ->sortable(),
                TextColumn::make("payment_method")
                    ->label("Metodo Pagamento")
                    ->searchable()
                    ->sortable(),
                TextColumn::make("payment_status")
                    ->label("Stato Pagamento")
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pending' => 'In Attesa',
                        'paid' => 'Pagato',
                        'refunded' => 'Rimborsato',
                        'failed' => 'Fallito',
                        default => $state,
                    })
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'paid' => 'success',
                        'refunded' => 'primary',
                        'failed' => 'danger',
                        default => 'gray',
                    })
                    ->searchable()
                    ->sortable(),
                TextColumn::make("total_price")
                    ->label("Prezzo Totale (€)")
                    ->money('eur', true)
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }
}
