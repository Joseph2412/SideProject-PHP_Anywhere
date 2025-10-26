<?php

namespace App\Filament\Admin\Pages;

use Filament\Pages\Page;
use App\Filament\Admin\Widgets\AdminStatsWidget;
use App\Filament\Admin\Widgets\RecentHostsTable;
use App\Filament\Admin\Widgets\CoworkingsByHostChart;


class Dashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.dashboard';

    public function getWidgets(): array
    {
        return [
            AdminStatsWidget::class,
            RecentHostsTable::class,
            CoworkingsByHostChart::class,
        ];
    }
}
