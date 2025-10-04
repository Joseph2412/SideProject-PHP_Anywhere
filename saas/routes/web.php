<?php

use App\Livewire\Auth\LoginPage;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;

Route::get('/', function () {
    return redirect('/login');
});

// Login Livewire component
Route::get('/login', LoginPage::class)->name('login');

Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');