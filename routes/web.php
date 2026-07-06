<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BurgerController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OrderController; // Adicionado o controlador de pedidos

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 1. Página Inicial Pública
Route::get('/', [BurgerController::class, 'index'])->name('home');

// 2. Rotas de Autenticação padrão do Laravel (Login, Registo, etc.)
Auth::routes();

// 3. Rotas Protegidas (Requer início de sessão)
Route::middleware(['auth'])->group(function () {
    
    // --- ROTAS DO CLIENTE ---
    // Dashboard do Cliente (Histórico de pedidos)
    Route::get('/dashboard', [OrderController::class, 'index'])->name('customer.dashboard');
    
    // Processar o pedido (Botão "Fazer Pedido")
    Route::post('/order/{burger}', [OrderController::class, 'store'])->name('order.store');
    
    // Cancelar o pedido
    Route::post('/order/{order}/cancel', [OrderController::class, 'cancel'])->name('order.cancel');


    // --- ROTAS DO ADMINISTRADOR ---

    // --- NOVAS ROTAS DO ADMINISTRADOR ---
    // Gestão de Clientes
    Route::put('/admin/users/{user}', [AdminController::class, 'updateUser'])->name('admin.users.update');
    Route::delete('/admin/users/{user}', [AdminController::class, 'destroyUser'])->name('admin.users.destroy');

    // Gestão de Pedidos (Mudar estado)
    Route::patch('/admin/orders/{order}/status', [AdminController::class, 'updateOrderStatus'])->name('admin.orders.status');

    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])
        ->name('admin.dashboard')
        ->middleware('can:is-admin'); 


    Route::post('/admin/burgers', [AdminController::class, 'store'])->name('admin.burgers.store');
    Route::delete('/admin/burgers/{burger}', [AdminController::class, 'destroy'])->name('admin.burgers.destroy');





});

