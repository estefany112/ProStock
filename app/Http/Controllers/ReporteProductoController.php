<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Exports\ReporteProductosExport;
use Maatwebsite\Excel\Facades\Excel;

class ReporteProductoController extends Controller
{
    public function index(Request $request)
    {
        // Tipo de reporte seleccionado
        $tipo = $request->tipo ?? 'todos';


        $productos = Producto::query();


        switch ($tipo) {

            case 'todos':
            // No se aplican filtros: muestra todos los productos.
            break;

            case 'sin_precio':

                $productos->where(function($q){
                    $q->whereNull('precio_unitario')
                      ->orWhere('precio_unitario', '<=', 0);
                });

            break;


            case 'sin_imagen':

                $productos->where(function ($q) {
                    $q->whereNull('image')
                    ->orWhere('image', '');
                });

            break;

        }

        $productos = $productos
            ->with(['categoria', 'fila', 'columna', 'nivel'])
            ->orderBy('descripcion')
            ->paginate(20)
            ->withQueryString();

        return view('reportes.productos.index', compact(
            'productos',
            'tipo'
        ));
    }

    public function excel(Request $request)
    {
        $tipo = $request->tipo ?? 'todos';


        return Excel::download(
            new ReporteProductosExport($tipo),
            'reporte_productos_'.$tipo.'.xlsx'
        );
    }
}