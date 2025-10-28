<?php

namespace App\Filament\Host\Resources;

use App\Filament\Host\Resources\CoworkingResource\Pages;
use App\Filament\Host\Resources\CoworkingResource\RelationManagers;
use App\Models\Coworking;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class CoworkingResource extends Resource
{
    protected static ?string $model = Coworking::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nome')
                    ->required(),
                Forms\Components\Textarea::make('description')
                    ->label('Descrizione'),
                Forms\Components\TextInput::make('city')
                    ->label('Città'),
                Forms\Components\TextInput::make('address')
                    ->label('Indirizzo'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('Nome'),
                Tables\Columns\TextColumn::make('city')->label('Città'),
                Tables\Columns\TextColumn::make('address')->label('Indirizzo'),
            ])
            ->filters([
                Tables\Filters\Filter::make('name')
                    ->label('Nome')
                    ->form([
                        Forms\Components\TextInput::make('value')->label('Nome'),
                    ])
                    ->query(fn (Builder $query, array $data) =>
                        isset($data['value']) && $data['value'] !== ''
                            ? $query->where('name', 'like', "%{$data['value']}%")
                            : $query
                    ),
                Tables\Filters\Filter::make('address')
                    ->label('Indirizzo')
                    ->form([
                        Forms\Components\TextInput::make('value')->label('Indirizzo'),
                    ])
                    ->query(fn (Builder $query, array $data) =>
                        isset($data['value']) && $data['value'] !== ''
                            ? $query->where('address', 'like', "%{$data['value']}%")
                            : $query
                    ),
                Tables\Filters\Filter::make('city')
                    ->label('Città')
                    ->form([
                        Forms\Components\TextInput::make('value')->label('Città'),
                    ])
                    ->query(fn (Builder $query, array $data) =>
                        isset($data['value']) && $data['value'] !== ''
                            ? $query->where('city', 'like', "%{$data['value']}%")
                            : $query
                    ),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('host_id', Auth::id());
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
            'index' => Pages\ListCoworkings::route('/'),
            'create' => Pages\CreateCoworking::route('/create'),
            'edit' => Pages\EditCoworking::route('/{record}/edit'),
            'view' => Pages\ViewCoworking::route('/{record}'), // aggiungi questa riga
        ];
    }
}
