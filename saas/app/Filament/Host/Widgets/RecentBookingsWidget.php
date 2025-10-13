<?php


namespace App\Filament\Host\Widgets;

use App\Models\Booking;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class RecentBookingsWidget extends TableWidget
{
    protected static bool $isLazy = true;

    protected static ?string $heading = 'Ultime 5 Prenotazioni';
    
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(fn (): Builder => 
                Booking::whereHas('coworking', function ($query) {
                    $query->where('host_id', Auth::id());
                })
                ->with(['coworking'])
                ->latest('created_at')
                ->limit(5)
            )
            ->columns([
                TextColumn::make('costumer_name')
                    ->label('Cliente')
                    ->searchable(false)
                    ->weight('medium'),
                    
                TextColumn::make('coworking.name')
                    ->label('Coworking')
                    ->searchable(false)
                    ->limit(20),
                    
                TextColumn::make('booking_date')
                    ->label('Data')
                    ->date('d/m/Y')
                    ->sortable(),
                    
                TextColumn::make('start_time')
                    ->label('Orario')
                    ->time('H:i')
                    ->formatStateUsing(fn ($record) => 
                        $record->start_time . ' - ' . $record->end_time
                    ),
                    
                TextColumn::make('total_price')
                    ->label('Prezzo')
                    ->money('EUR')
                    ->sortable(),
                    
                BadgeColumn::make('status')
                    ->label('Stato')
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'confirmed', 
                        'danger' => 'cancelled',
                        'info' => 'completed',
                    ])
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pending' => 'In Attesa',
                        'confirmed' => 'Confermata',
                        'cancelled' => 'Cancellata', 
                        'completed' => 'Completata',
                        default => $state,
                    }),
                    
                TextColumn::make('created_at')
                    ->label('Prenotata il')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->paginated(false)
            ->searchable(false)
            ->emptyStateHeading('Nessuna prenotazione')
            ->emptyStateDescription('Non hai ancora ricevuto prenotazioni per i tuoi coworking.')
            ->emptyStateIcon('heroicon-o-calendar');
    }

    public static function canView(): bool
    {
        return Auth::check() && Auth::user()->role === 'Host';
    }
}