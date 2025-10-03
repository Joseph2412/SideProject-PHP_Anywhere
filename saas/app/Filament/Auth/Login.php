<?php
// app/Filament/Auth/CommonLogin.php
namespace App\Filament\Auth;

use Filament\Pages\Auth\Login as BaseLogin;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Illuminate\Support\Facades\Auth;

class CommonLogin extends BaseLogin
{
    // Form: login = email o username
    public function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('login')
                ->label('Email')
                ->required()
                ->autocomplete('email')
                ->autofocus(),
            TextInput::make('password')
                ->password()
                ->revealable()
                ->required(),
        ]);
    }

    protected function getCredentialsFromFormData(array $data): array
    {
        $field = filter_var($data['login'], FILTER_VALIDATE_EMAIL) ? 'email' : 'name';
        return [$field => $data['login'], 'password' => $data['password']];
    }

    //Redirect POST LOGIN in base al ruolo
    protected function getRedirectUrl(): ?string
    {
        $user = Auth::user();
        if (! $user) {
            return parent::getRedirectUrl(); // fallback
        }

        // Priorità: admin > host (adatta se vuoi l’inverso)
        if (method_exists($user, 'hasRole') && $user->hasRole('admin')) {
            return '/admin';
        }
        if (method_exists($user, 'hasRole') && $user->hasRole('host')) {
            return '/host';
        }
    }
}
