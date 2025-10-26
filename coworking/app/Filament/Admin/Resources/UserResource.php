<?php

namespace App\Filament\Admin\Resources;

use App\Models\User;
use Filament\Resources\Resource;
use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationGroup = 'Gestione Host';

    public static function canAccess(): bool
    {
        return Auth::user()?->role === 'admin';
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')->required(),
            Forms\Components\TextInput::make('email')->email()->required(),
            Forms\Components\Select::make('role')->options([
                'admin' => 'Admin',
                'host'  => 'Host',
            ]),
            Forms\Components\TextInput::make('password')
                ->password()
                ->revealable()
                ->required(fn($record) => $record === null)
                ->dehydrateStateUsing(fn($state) => bcrypt($state)),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('id')->sortable(),
            Tables\Columns\TextColumn::make('name')->searchable(),
            Tables\Columns\TextColumn::make('email')->searchable(),
            Tables\Columns\BadgeColumn::make('role')->colors([
                'success' => 'admin',
                'info'    => 'host',
            ]),
        ]);
    }
}
