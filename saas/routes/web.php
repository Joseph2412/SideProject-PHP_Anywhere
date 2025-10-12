<?php

use App\Livewire\Auth\LoginPage;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\S3UploadController;

Route::get('/', function () {
    return redirect('/login');
});

// Login Livewire component
Route::get('/login', LoginPage::class)->name('login');

Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// Route::middleware('auth:sanctum')->post('/s3/sign', [S3UploadController::class, 'sign']);