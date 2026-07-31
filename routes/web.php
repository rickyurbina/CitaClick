<?php

use App\Http\Controllers\BarberiaController;
use App\Http\Controllers\EmpresasController;
use App\Livewire\BuscarCliente;
use App\Livewire\Superadmin\VerificarUsuario as SuperadminVerificarUsuario;
use App\Livewire\VerificarUsuario;
use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/dashboard',SuperadminVerificarUsuario::class)->name('superadmin');

Route::get('/{empresa:slug}', BuscarCliente::class)->name('clientes');

Route::get('/{empresa:slug}/panel', VerificarUsuario::class)->name('usuarios');




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
