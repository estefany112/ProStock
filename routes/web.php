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
