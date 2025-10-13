<?php

use App\Livewire\Auth\LoginPage;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Livewire\Auth\RegisterPage;

Route::get('/', function () {
    return redirect('/login');
});

// Login Livewire component

Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

//Rotte Register,Login, Forgot Password e Reset Password
Route::get('/login', LoginPage::class)->name('login');


Route::get('/register', RegisterPage::class)->name('register');

Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->name('forgot-password');

Route::get('/reset-password/{token}', function ($token) {
    return view('auth.reset-password', ['token' => $token]);
})->name('reset-password');
