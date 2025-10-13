<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Validate;
use App\Models\User;

class ResetPasswordPage extends Component
{
    public string $token;
    
    #[Validate('required|email')]
    public $email = '';

    #[Validate('required|min:8|confirmed')]
    public $password = '';

    #[Validate('required')]
    public $password_confirmation = '';

    public function mount($token)
    {
        $this->token = $token;
    }

    public function resetPassword()
    {
        $this->validate();

        $status = Password::reset(
            [
                'email' => $this->email,
                'password' => $this->password,
                'password_confirmation' => $this->password_confirmation,
                'token' => $this->token,
            ],
            function (User $user, string $password) {
                $user->forceFill(['password' => Hash::make($password)])->save();
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            session()->flash('success', 'Password reimpostata correttamente. Ora puoi effettuare il login.');
            return redirect()->route('login');
        }

        $this->addError('email', 'Link di reset non valido o scaduto.');
    }

    public function render()
    {
        return view('livewire.auth.reset-password-page');
    }
}
