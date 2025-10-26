<?php

namespace App\Filament\Host\Pages;

use Filament\Pages\Page;
use App\Filament\Host\Widgets\HostStatsWidget;
use App\Filament\Host\Widgets\QuickActionsWidget;
use App\Filament\Host\Widgets\MyCoworkingsTable;

class Dashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.host.pages.dashboard';

      public function getWidgets(): array
    {
        return [
            HostStatsWidget::class,
            QuickActionsWidget::class,
            MyCoworkingsTable::class,
        ];
    }
}
