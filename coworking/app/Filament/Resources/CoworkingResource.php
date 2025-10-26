<?php

namespace App\Filament\Resources;

use App\Models\Coworking;
use Filament\Resources\Resource;
use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class CoworkingResource extends Resource
{
    protected static ?string $model = Coworking::class;
    protected static ?string $navigationIcon = 'heroicon-o-building-office';

    protected static function getNavigationGroup(): ?string
    {
        $user = Auth::user();
        return $user?->role === 'admin'
            ? 'Gestione Host'
            : 'I miei Coworking';
    }

    public static function form(Form $form): Form
    {
        $user = Auth::user();

        return $form->schema([
            Forms\Components\TextInput::make('name')->required(),
            Forms\Components\Textarea::make('description'),

            Forms\Components\Toggle::make('is_active')
                ->default(true)
                ->visible(fn() => $user->role === 'host'),

            Forms\Components\Select::make('host_id')
                ->relationship('host', 'name')
                ->visible(fn() => $user->role === 'admin')
                ->required(),

            Forms\Components\Hidden::make('host_id')
                ->default(fn() => $user->role === 'host' ? $user->id : null),
        ]);
    }

    public static function table(Table $table): Table
    {
        $user = Auth::user();

        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('Coworking')->searchable(),
                Tables\Columns\TextColumn::make('host.name')
                    ->label('Host')
                    ->visible(fn() => $user->role === 'admin'),
                Tables\Columns\IconColumn::make('is_active')->boolean(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make()
                    ->visible(fn() => $user->role === 'host'),
                Tables\Actions\DeleteAction::make()
                    ->visible(fn() => $user->role === 'host'),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make()
                    ->visible(fn() => $user->role === 'host'),
            ]);
    }

    /** Query dinamica */
    public static function getEloquentQuery(): Builder
    {
        $user = Auth::user();

        return match ($user->role) {
            'admin' => parent::getEloquentQuery(),                   // vede tutto
            'host'  => parent::getEloquentQuery()->where('host_id', $user->id),
            default => parent::getEloquentQuery()->whereRaw('1=0'),
        };
    }

    /** Controllo autorizzazioni: Filament usa le policy Laravel */
    public static function canEdit($record): bool
    {
        return Auth::user()->role === 'host';
    }

    public static function canDelete($record): bool
    {
        return Auth::user()->role === 'host';
    }

    public static function canCreate(): bool
    {
        return Auth::user()->role === 'host';
    }
}
