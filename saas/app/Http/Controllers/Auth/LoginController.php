<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login'); // resources/views/auth/login.blade.php
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'string'],   // email o username
            'password' => ['required', 'string'],
        ]);

        // scegli il campo: email se valido, altrimenti "name"
        $field = filter_var($credentials['email'], FILTER_VALIDATE_EMAIL) ? 'email' : 'name';

        if (! Auth::attempt([$field => $credentials['email'], 'password' => $credentials['password']], $request->boolean('remember'))) {
            return back()->withErrors(['email' => 'Credenziali non valide'])->onlyInput('email');
        }

        $request->session()->regenerate();

        $user = Auth::user();

        // con Spatie
        if ($user->hasRole('admin')) {
            return redirect()->intended('/admin');
        }
        if ($user->hasRole('host')) {
            return redirect()->intended('/host');
        }

        // se non ha ruoli noti: esci o manda dove preferisci
        Auth::logout();
        return redirect()->route('login')->withErrors(['login' => 'Nessun ruolo autorizzato.']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
