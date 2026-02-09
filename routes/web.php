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
use App\Http\Controllers\EmployeeController;

// PÁGINA PRINCIPAL
Route::get('/', function () {
    return view('welcome');
});

// DASHBOARD - SOLO PARA PERSONA AUTENTICADAS
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// RUTAS PROTEGIDAS
Route::middleware(['auth'])->group(function () {

    // PERFIL DE USUARIO
    Route::get('/profile',  [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // MÓDULOS DE SISTEMA
    Route::resource('productos', ProductoController::class);
    Route::resource('entradas', EntradaController::class);
    Route::resource('categorias', CategoriaController::class);
    Route::resource('salidas', SalidaController::class);
    Route::resource('filas', FilaController::class);
    Route::resource('columnas', ColumnaController::class);
    Route::resource('niveles', NivelController::class);

    // MÓDULO DE ADMIN
    Route::get('/admin/users', [UserController::class, 'index'])
        ->name('admin.users');

    Route::post('/admin/users/{user}/roles', [UserController::class, 'updateRole'])
        ->name('admin.users.roles')
        ->middleware('permission:assign_roles');

    // MÓDULO DE PRODUCTOS
    Route::resource('productos', ProductoController::class)
        ->middleware('permission:view_products');

    // MÓDULO DE ENTRADAS
    Route::resource('entradas', EntradaController::class)
        ->middleware('permission:view_entries');

    // MÓDULO DE SALIDAS
    Route::resource('salidas', SalidaController::class)
        ->middleware('permission:view_exits');

    // MÓDULO DE CAJA CHICA
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
    
    Route::get('/caja/history', [PettyCashController::class, 'history'])
        ->name('caja.history')
        ->middleware('permission:caja.report');

    // MÓDULO DE EMPLEADOS
    Route::get('/employees', [EmployeeController::class, 'index'])->name('employees.index');
    Route::get('/employees/create', [EmployeeController::class, 'create'])->name('employees.create');
    Route::post('/employees', [EmployeeController::class, 'store'])->name('employees.store');
    Route::get('/employees/{employee}/edit', [EmployeeController::class, 'edit'])->name('employees.edit');
    Route::put('/employees/{employee}', [EmployeeController::class, 'update'])->name('employees.update');
    Route::patch('/employees/{employee}/toggle', [EmployeeController::class, 'toggle'])->name('employees.toggle');
        
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

Route::get('/hora', function () {
    return now()->format('d/m/Y H:i:s');
});

});

require __DIR__.'/auth.php';
