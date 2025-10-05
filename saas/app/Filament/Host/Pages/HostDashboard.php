<?php

namespace App\Filament\Host\Pages;

use Filament\Pages\Page;

class HostDashboard extends Page
{
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-home';
    protected string $view = 'filament.host.pages.host-dashboard';
}
