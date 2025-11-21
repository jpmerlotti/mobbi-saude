<?php

use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Terms\AcceptTermsController;
use App\Http\Controllers\Equipments\DeleteEquipmentController;
use App\Http\Controllers\Views\AboutUsController;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;
use App\Livewire\Pages\Home;
use App\Livewire\Pages\ShowEquipment;
use App\Livewire\Pages\Support;
use App\Livewire\Pages\User\MyEquipments\CreateEquipment;
use App\Livewire\Pages\User\MyEquipments\EditEquipment;
use App\Livewire\Pages\User\MyEquipments\Equipments;
use App\Livewire\Pages\User\MyRentals\Rentals;
use App\Livewire\Pages\User\Profile;
use Illuminate\Support\Facades\Route;


Route::prefix('/auth')->group(function () {
    Route::get('/login', Login::class)->name('auth.login');
    Route::get('/register', Register::class)->name('auth.register');

    Route::middleware('auth')
        ->post('/logout', LogoutController::class)
        ->name('auth.logout');
});

Route::get('/', Home::class)->name('home');
Route::get('/equipments/{equipment}', ShowEquipment::class)->name('show-equipment');
Route::get('/support', Support::class)->name('support');
Route::view('/contact', 'pages.contact')->name('contact');
Route::get('/about-us', AboutUsController::class)->name('about-us');

Route::prefix('/terms')->group(function () {
    Route::view('/view', 'pages.terms-of-use')->name('terms.view');
    Route::middleware('auth')
        ->post('/accept', AcceptTermsController::class)->name('terms.accept');
});

Route::prefix('/me')->middleware('auth')->group(function () {
    Route::get('/', Profile::class)->name('profile');

    # Sessão meus equipamentos
    Route::prefix('/equipments')->group(function () {
        Route::get('/', Equipments::class)->name('my-equipments.index');
        Route::get('/create', CreateEquipment::class)->name('my-equipments.create');
        Route::get('/{equipment}/edit', EditEquipment::class)->name('my-equipments.edit');
        Route::delete('/{equipment}/destroy', DeleteEquipmentController::class)->name('my-equipments.delete');
    });

    # Sessão meus aluguéis
    Route::prefix('/rentals')->group(function () {
        Route::get('/', Rentals::class)->name('my-rentals.index');
    });
});
