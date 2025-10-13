<?php

use App\Livewire\Auth\LoginPage;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Livewire\Auth\ForgotPasswordPage;
use App\Livewire\Auth\RegisterPage;
use App\Livewire\Auth\ResetPasswordPage;

Route::get('/', function () {
    return redirect('/login');
});

// Login Livewire component

Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

//Rotte Register,Login, Forgot Password e Reset Password
Route::get('/login', LoginPage::class)->name('login');


Route::get('/register', RegisterPage::class)->name('register');

Route::get('/forgot-password', ForgotPasswordPage::class)->name('password.request');

Route::get('/reset-password/{token}', ResetPasswordPage::class)->name('password.reset');
