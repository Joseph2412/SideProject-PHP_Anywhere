<?php

namespace App\Filament\Host\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Auth;

class WelcomeWidget extends Widget
{
    protected static bool $isLazy = true;
    
    protected string $view = 'filament.widgets.welcome-widget';
    
    protected int | string | array $columnSpan = 'full';
    
    protected static ?int $sort = -10; // Per metterlo in cima
    
    protected function getViewData(): array
    {
        $user = Auth::user();
        
        return [
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role,
            'greeting' => $this->getGreeting(),
            'current_time' => now()->format('d/m/Y - H:i'),
        ];
    }
    
    public function getUserData(): array
    {
        return $this->getViewData();
    }
    
    private function getGreeting(): string
    {
        $hour = now()->hour;
        
        if ($hour < 12) {
            return 'Buongiorno';
        } elseif ($hour < 18) {
            return 'Buon pomeriggio';
        } else {
            return 'Buonasera';
        }
    }

    public static function canView(): bool
    {
        return Auth::check() && Auth::user()->role === 'Host';
    }
}