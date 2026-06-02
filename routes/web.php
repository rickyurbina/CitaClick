<?php

use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/admin',function () {
    return view('admin');
});

Route::get('/admin/empresas',function () {
    return view('administrar-empresa');
});

Route::get('/tus-citas',function () {
    return view('tus-citas');
});

Route::get('/empresas',function () {
    return view('empresas');
});

Route::get('/{empresa}',function ($empresa) {
    return view('tu-empresa', [ 'tu_empresa' => $empresa ]);
});


Route::get('/{empresa}/agendar-cita',function ($empresa) {
    return view('post.agendar_cita', [ 
        'tu_empresa' => $empresa 
    ]);
});

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
