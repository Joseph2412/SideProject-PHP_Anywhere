<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Validate;

class ForgotPasswordPage extends Component
{
    #[Validate('required|email')]
    public $email = '';

    public function sendResetLink()
    {
        $this->validate();

        $status = Password::sendResetLink(['email' => $this->email]);

        if ($status === Password::RESET_LINK_SENT) {
            session()->flash('success', 'Abbiamo inviato un link per reimpostare la password alla tua email.');
        } else {
            $this->addError('email', 'Non esiste un utente registrato con questa email.');
        }
    }

    public function render()
    {
        return view('livewire.auth.forgot-password-page');
    }
}
