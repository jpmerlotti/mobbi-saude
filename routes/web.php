<?php

use App\Http\Controllers\Auth\LogoutController;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;
use App\Livewire\Pages\Home;
use Illuminate\Support\Facades\Route;


Route::prefix('/auth')->group(function () {
    Route::get('/login', Login::class)->name('auth.login');
    Route::get('/register', Register::class)->name('auth.register');
    Route::middleware('auth')
        ->post('/logout', [LogoutController::class])
        ->name('auth.logout');
});

Route::get('/', Home::class)->name('home');

Route::middleware('auth')->group(function () {
    //    
});