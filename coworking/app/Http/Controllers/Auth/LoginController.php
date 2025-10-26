<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check()) {
            $user = Auth::user();

            // redirect automatico se già loggato
            return match ($user->role) {
                'admin' => redirect('/admin'),
                'host'  => redirect('/host'),
                default => redirect('/'),
            };
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();

            // 🔹 Reset del panel Filament precedente
            session()->forget('filament-panel');

            // 🔹 Redirect pulito in base al ruolo
            return match ($user->role) {
                'admin' => redirect('/admin'),
                'host'  => redirect('/host'),
                default => redirect('/'),
            };
        }

        return back()->withErrors([
            'email' => 'Credenziali non valide.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // 🔹 Resetta eventuale stato del panel
        session()->forget('filament-panel');

        return redirect('/login');
    }
}
