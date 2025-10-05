<?php

namespace App\Filament\Host\Resources\Coworkings;

use App\Filament\Host\Resources\Coworkings\Pages\CreateCoworking;
use App\Filament\Host\Resources\Coworkings\Pages\EditCoworking;
use App\Filament\Host\Resources\Coworkings\Pages\ListCoworkings;
use App\Filament\Host\Resources\Coworkings\Pages\ViewCoworking;
use App\Filament\Host\Resources\Coworkings\Schemas\CoworkingForm;
use App\Filament\Host\Resources\Coworkings\Schemas\CoworkingInfolist;
use App\Filament\Host\Resources\Coworkings\Tables\CoworkingsTable;
use App\Models\Coworking;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class CoworkingResource extends Resource
{
    protected static ?string $model = Coworking::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return CoworkingForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return CoworkingInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CoworkingsTable::configure($table);
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
            'index' => ListCoworkings::route('/'),
            'create' => CreateCoworking::route('/create'),
            'view' => ViewCoworking::route('/{record}'),
            'edit' => EditCoworking::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        $userId = Auth::id();
        
        return parent::getEloquentQuery()
            ->where("host_id", $userId);
    }
}
