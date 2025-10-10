<?php

namespace App\Filament\Host\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Auth;

class WelcomeWidget extends Widget
{
    protected string $view = 'filament.host.widgets.welcome-widget';
    
    protected int | string | array $columnSpan = 'full';
    
    protected static ?int $sort = -10; // Per metterlo in cima
    
    public function getUserData(): array
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
}