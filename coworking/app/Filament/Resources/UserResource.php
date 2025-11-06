<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nome')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->label('Email')
                    ->email()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('password')
                    ->label('Password')
                    ->password()
                    ->required(fn (string $operation): bool => $operation === 'create')
                    ->dehydrated(fn ($state) => filled($state))
                    ->minLength(8),
                Forms\Components\Select::make('role')
                    ->label('Ruolo')
                    ->options([
                        'admin' => 'Admin',
                        'user' => 'User',
                        'manager' => 'Manager',
                    ])
                    ->required()
                    ->default('user'),
                
                // Mostra i coworking solo in modalità edit/view
                Forms\Components\Placeholder::make('coworkings_list')
                    ->label('Coworking associati')
                    ->content(function ($record) {
                        // Se il record non esiste (creazione), non mostrare nulla
                        if (!$record) {
                            return 'I coworking associati saranno visibili dopo il salvataggio.';
                        }
                        
                        // Carica la relazione se non è già caricata
                        if (!$record->relationLoaded('coworkings')) {
                            $record->load('coworkings');
                        }
                        
                        return $record->coworkings->isNotEmpty()
                            ? $record->coworkings->pluck('name')->implode('<br>')
                            : 'Nessun coworking associato.';
                    })
                    ->visible(fn (string $operation): bool => $operation !== 'create'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nome')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('role')
                    ->label('Ruolo')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'admin' => 'danger',
                        'manager' => 'warning',
                        'user' => 'success',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('coworkings_count')
                    ->label('Coworking')
                    ->counts('coworkings')
                    ->badge(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Creato il')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Aggiornato il')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('role')
                    ->label('Ruolo')
                    ->options([
                        'admin' => 'Admin',
                        'user' => 'User',
                        'manager' => 'Manager',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
