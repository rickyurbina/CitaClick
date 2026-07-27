<?php

use App\Http\Controllers\BarberiaController;
use App\Http\Controllers\EmpresasController;
use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/{empresa:slug}', [BarberiaController::class, 'showCliente']);

Route::get('/{empresa:slug}/panel', [BarberiaController::class, 'showRecepcion']);

Route::get('/dashboard',[EmpresasController::class, 'show']);

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

require __DIR__.'/auth.php';
