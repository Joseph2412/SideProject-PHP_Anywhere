<?php

namespace App\Filament\Host\Widgets;

use App\Models\Coworking;
use App\Models\Booking;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class CoworkingStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $hostId = Auth::id();
        
        // Totale coworking dell'host
        $totalCoworkings = Coworking::where('host_id', $hostId)->count();
        
        // Coworking attivi (aperti)
        $activeCoworkings = Coworking::where('host_id', $hostId)
            ->where('status', 'open')
            ->count();
            
        // Prenotazioni di questo mese per i coworking dell'host
        $monthlyBookings = Booking::whereHas('coworking', function ($query) use ($hostId) {
                $query->where('host_id', $hostId);
            })
            ->whereMonth('booking_date', now()->month)
            ->whereYear('booking_date', now()->year)
            ->count();
            
        // Prenotazioni di oggi
        $todayBookings = Booking::whereHas('coworking', function ($query) use ($hostId) {
                $query->where('host_id', $hostId);
            })
            ->whereDate('booking_date', today())
            ->count();
            
        // Revenue del mese (somma dei prezzi delle prenotazioni confermate)
        $monthlyRevenue = Booking::whereHas('coworking', function ($query) use ($hostId) {
                $query->where('host_id', $hostId);
            })
            ->where('status', 'confirmed')
            ->whereMonth('booking_date', now()->month)
            ->whereYear('booking_date', now()->year)
            ->sum('total_price');

        return [
            Stat::make('Coworking Totali', $totalCoworkings)
                ->description($activeCoworkings . ' attivi')
                ->descriptionIcon('heroicon-m-building-office-2')
                ->color('primary'),
                
            Stat::make('Prenotazioni Oggi', $todayBookings)
                ->description('Per i tuoi coworking')
                ->descriptionIcon('heroicon-m-calendar-days')
                ->color('success'),
                
            Stat::make('Prenotazioni Questo Mese', $monthlyBookings)
                ->description('Totale mensile')
                ->descriptionIcon('heroicon-m-chart-bar')
                ->color('info'),
                
            Stat::make('Revenue Mese', '€' . number_format($monthlyRevenue, 2))
                ->description('Prenotazioni confermate')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('warning'),
        ];
    }

    public static function canView(): bool
    {
        return \Illuminate\Support\Facades\Auth::check() && \Illuminate\Support\Facades\Auth::user()->role === 'Host';
    }
}