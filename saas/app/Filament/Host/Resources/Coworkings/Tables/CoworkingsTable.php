<?php

namespace App\Filament\Host\Resources\Coworkings\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class CoworkingsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nome')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('city')
                    ->label('Città')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('status')
                    ->label('Stato')
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'open' => 'Aperto',
                        'closed' => 'Chiuso',
                        'inactive' => 'Inattivo',
                        default => $state,
                    })
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'open' => 'success',
                        'closed' => 'warning',
                        'inactive' => 'gray',
                        default => 'gray',
                    })
                    ->searchable()
                    ->sortable(),
                TextColumn::make("space_type")
                    ->label("Tipologia")
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'open_space' => 'Spazio Aperto',
                        'private_office' => 'Ufficio Privato',
                        'meeting_room' => 'Sala Riunioni',
                        'conference_room' => 'Sala Conferenze',
                        'hot_desk' => 'Postazione Condivisa',
                        default => $state,
                    })
                    ->searchable()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Creato il')
                    ->dateTime('d/m/Y H:i')
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
