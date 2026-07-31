<?php

use App\Http\Controllers\BarberiaController;
use App\Http\Controllers\EmpresasController;
use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DueñoController;
use App\Http\Controllers\RecepcionistaController;
use App\Http\Controllers\ColaboradorController;
use App\Http\Controllers\ClienteController;
use App\Livewire\BuscarCliente;
use Livewire\Volt\Volt;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/
// Rutas públicas (login)
Route::get('/login-cliente', [AuthController::class, 'showLoginCliente'])->name('login.cliente');
Route::get('/login-usuario', [AuthController::class, 'showLoginUsuario'])->name('login.usuario');
Route::get('/login-admin', [AuthController::class, 'showLoginAdmin'])->name('login.admin');

// Admin
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/negocios', [AdminController::class, 'negociosIndex'])->name('negocios.index');
    Route::get('/negocios/create', [AdminController::class, 'negociosCreate'])->name('negocios.create');
    Route::get('/negocios/{id}/edit', [AdminController::class, 'negociosEdit'])->name('negocios.edit');
    Route::get('/servicios', [AdminController::class, 'serviciosIndex'])->name('servicios.index');
});

// Dueño
Route::prefix('dueño')->name('dueño.')->group(function () {
    Route::get('/dashboard', [DueñoController::class, 'dashboard'])->name('dashboard');
    Route::get('/citas', [DueñoController::class, 'citasIndex'])->name('citas.index');
    Route::get('/citas/{id}/edit', [DueñoController::class, 'citasEdit'])->name('citas.edit');
    Route::get('/servicios/create', [DueñoController::class, 'serviciosCreate'])->name('servicios.create');
    Route::get('/servicios/{id}/edit', [DueñoController::class, 'serviciosEdit'])->name('servicios.edit');
    Route::get('/colaboradores/create', [DueñoController::class, 'colaboradoresCreate'])->name('colaboradores.create');
    Route::get('/colaboradores/{id}/edit', [DueñoController::class, 'colaboradoresEdit'])->name('colaboradores.edit');
});

// Recepcionista
Route::prefix('recepcionista')->name('recepcionista.')->group(function () {
    Route::get('/colaboradores', [RecepcionistaController::class, 'colaboradoresIndex'])->name('colaboradores.index');
});

// Colaborador
Route::prefix('colaborador')->name('colaborador.')->group(function () {
    Route::get('/citas', [ColaboradorController::class, 'citasIndex'])->name('citas.index');
});

// Cliente
Route::prefix('cliente')->name('cliente.')->group(function () {
    Route::get('/servicios', [ClienteController::class, 'serviciosIndex'])->name('servicios.index');
    Route::get('/agendar', [ClienteController::class, 'agendarIndex'])->name('agendar.index');
});