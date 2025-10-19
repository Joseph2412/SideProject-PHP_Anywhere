<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Filament\Notifications\Notification;
use App\Models\User;

class LoginPage extends Component
{
    public $email = '';
    public $password = '';

    protected $rules = [
        'email' => 'required|email',
        'password' => 'required',
    ];

    public function mount()
    {
        if (Auth::check()) {
            return redirect($this->redirectToRole());
        }
    }

    public function login()
    {
        $this->validate();

        $user = User::where('email', $this->email)->first();

        if (! $user || ! Hash::check($this->password, $user->password)) {
            Notification::make()
                ->title('Credenziali non valide')
                ->danger()
                ->send();
            return;
        }

        Auth::login($user);
        session()->regenerate();

        return redirect($this->redirectToRole());
    }

    protected function redirectToRole(): string
    {
        $user = Auth::user();

        return match ($user->role) {
            'Admin' => '/admin',
            'Host' => '/host',
            default => '/',
        };
    }

    public function render()
    {
        return view('livewire.auth.login-page');
    }
}
