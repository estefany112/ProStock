<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\EntradaController;
use App\Http\Controllers\SalidaController;
use App\Http\Controllers\FilaController;
use App\Http\Controllers\ColumnaController;
use App\Http\Controllers\NivelController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\PettyCashController;

// Página principal
Route::get('/', function () {
    return view('welcome');
});

// Dashboard (solo usuarios autenticados y verificados)
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Rutas protegidas
Route::middleware(['auth'])->group(function () {

    // Perfil del usuario
    Route::get('/profile',  [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Módulos del sistema
    Route::resource('productos', ProductoController::class);
    Route::resource('entradas', EntradaController::class);
    Route::resource('categorias', CategoriaController::class);
    Route::resource('salidas', SalidaController::class);
    Route::resource('filas', FilaController::class);
    Route::resource('columnas', ColumnaController::class);
    Route::resource('niveles', NivelController::class);

    Route::get('/admin/users', [UserController::class, 'index'])
        ->name('admin.users');

    Route::post('/admin/users/{user}/roles', [UserController::class, 'updateRole'])
        ->name('admin.users.roles')
        ->middleware('permission:assign_roles');

    Route::resource('productos', ProductoController::class)
        ->middleware('permission:view_products');

    Route::resource('entradas', EntradaController::class)
        ->middleware('permission:view_entries');

    Route::resource('salidas', SalidaController::class)
        ->middleware('permission:view_exits');

    Route::get('/caja', [PettyCashController::class, 'index'])
        ->name('caja.index')
        ->middleware('permission:caja.view');

    Route::post('/caja/open', [PettyCashController::class, 'open'])
        ->middleware('permission:caja.open');

    Route::post('/caja/close', [PettyCashController::class, 'close'])
        ->name('caja.close')
        ->middleware('permission:caja.close');

    Route::post('/caja/movement', [PettyCashController::class, 'storeMovement'])
        ->middleware('permission:caja.move');
    
    Route::get('/caja/historico', [PettyCashController::class, 'history'])
    ->name('caja.history')
    ->middleware('permission:caja.report');
        
    Route::get('/prostock', function () {
        return view('prostock.index');
    })->name('prostock.index');

    Route::get('/test', function () {
    return view('dashboard.index', [
        'totalCategorias' => 0,
        'totalProductos'  => 0,
        'stockTotal'      => 0,
        'stockBajo'       => 0,
    ]);
});

});

require __DIR__.'/auth.php';
