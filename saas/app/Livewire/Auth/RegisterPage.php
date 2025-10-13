<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Validate;
use App\Models\User;

class RegisterPage extends Component
{
    protected $layout = 'components.layouts.app';

    #[Validate('required|string|min:3')]
    public $name = '';

    #[Validate('required|email|unique:users,email')]
    public $email = '';

    #[Validate('required|min:3|confirmed')]
    public $password = '';

    #[Validate('required')]
    public $password_confirmation = '';

    public function mount()
    {
        if (Auth::check()) {
            return redirect($this->redirectToRole());
        }
    }

    public function register()
    {
        $this->validate();

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'role' => 'Host', // ruolo predefinito
        ]);
        
        session()->flash('success', 'Registrazione avvenuta con successo! Ora puoi effettuare il login.');

        return redirect()->route("login");
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
        return view('livewire.auth.register-page');
    }
}
