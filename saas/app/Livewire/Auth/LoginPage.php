<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Filament\Notifications\Notification;
use Livewire\Attributes\Validate;
use App\Models\User;

class LoginPage extends Component
{
    protected $layout = 'components.layouts.app';

    #[Validate('required|email')]
    public $email = '';

    #[Validate('required')]
    public $password = '';

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

        if(!$user) {
            $this->addError('email', 'Nessun account trovato con questa email.');
            return;
        }

         if (!\Illuminate\Support\Facades\Hash::check($this->password, $user->password)) {
        $this->addError('password', 'Password non corretta');
            return;
        }

        Auth::login($user);
        session()->regenerate();
        return redirect($this->redirectToRole());


        $credentials = [
            'email' => $this->email,
            'password' => $this->password
        ];

        if (Auth::attempt($credentials)) {
            session()->regenerate();
            return redirect($this->redirectToRole());
        }

        Notification::make()
            ->title('Credenziali non valide')
            ->danger()
            ->send();
    }

    protected function redirectToRole(): string
    {
        $user = Auth::user();

        return match (true) {
            $user->role === 'Admin' => '/admin',
            $user->role === 'Host' => '/host',
            default => '/',
        };
    }

    public function render()
    {
        return view('livewire.auth.login-page');
    }
}
