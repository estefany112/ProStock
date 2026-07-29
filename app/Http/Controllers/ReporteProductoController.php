<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;

class ReporteProductoController extends Controller
{
    public function index(Request $request)
    {
        // Tipo de reporte seleccionado
        $tipo = $request->tipo ?? 'sin_precio';


        $productos = Producto::query();


        switch ($tipo) {

            case 'sin_precio':

                $productos->where(function($q){
                    $q->whereNull('precio_unitario')
                      ->orWhere('precio_unitario', 0);
                });

            break;


            case 'sin_imagen':

                $productos->whereNull('image')
                         ->orWhere('image', '');

            break;

        }


        $productos = $productos->with('categoria')
                               ->orderBy('descripcion')
                               ->paginate(20);


        return view('reportes.productos.index', compact(
            'productos',
            'tipo'
        ));
    }
}