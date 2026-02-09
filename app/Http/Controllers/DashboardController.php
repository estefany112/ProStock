<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categoria;
use App\Models\Producto;
use App\Models\Employee;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard.index', [
            'totalCategorias' => Categoria::count(),
            'totalProductos'  => Producto::count(),
            'stockTotal'      => Producto::sum('stock_actual'),
            'stockBajo'       => Producto::where('stock_actual', '<=', 5)->count(),
            'totalEmpleados' => Employee::count(),
            'totalUsuarios' => User::count(),
        ]);
    }
}
