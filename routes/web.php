<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ContaController;
use App\Http\Controllers\ListaContasController;

Route::get('/', function () {
    return redirect()->route('login');
});

// Login e logout
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'logar'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Paginas que exigem login (token na sessao)
Route::middleware('token')->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Clientes
    Route::get('/clientes', [ClienteController::class, 'index'])->name('clientes.index');
    Route::get('/clientes/novo', [ClienteController::class, 'create'])->name('clientes.create');
    Route::post('/clientes', [ClienteController::class, 'store'])->name('clientes.store');
    Route::get('/clientes/{id}/editar', [ClienteController::class, 'edit'])->name('clientes.edit');
    Route::put('/clientes/{id}', [ClienteController::class, 'update'])->name('clientes.update');

    // Contas de um cliente
    Route::get('/clientes/{id}/contas', [ContaController::class, 'index'])->name('contas.index');
    Route::post('/clientes/{id}/contas', [ContaController::class, 'store'])->name('contas.store');

    // Lista de todas as contas
    Route::get('/contas', [ListaContasController::class, 'index'])->name('contas.todas');

    // Uma conta (detalhe, extracto, bloquear, desbloquear)
    Route::get('/contas/{numero}', [ContaController::class, 'show'])->name('contas.show');
    Route::put('/contas/{numero}/bloquear', [ContaController::class, 'bloquear'])->name('contas.bloquear');
    Route::put('/contas/{numero}/desbloquear', [ContaController::class, 'desbloquear'])->name('contas.desbloquear');

    // Depositos
    Route::get('/depositos', [ContaController::class, 'formDeposito'])->name('depositos.form');
    Route::post('/depositos', [ContaController::class, 'deposito'])->name('depositos.store');
});