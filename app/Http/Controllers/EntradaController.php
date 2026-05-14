<?php

namespace App\Http\Controllers;

use App\Models\Entrada;
use App\Models\Producto;
use Illuminate\Http\Request;

class EntradaController extends Controller
{
    /**
     * Muestra el historial de entradas con buscador optimizado.
     */
    public function index(Request $request)
    {
        $query = Entrada::with([
            'producto.categoria',
            'producto.fila',
            'producto.columna',
            'producto.nivel',
        ]);

        if ($request->filled('search')) {
            $search = trim($request->search);

            $query->where(function ($q) use ($search) {
                $q->where('motivo', 'like', "%{$search}%")
                ->orWhereHas('producto', function ($p) use ($search) {
                    $p->where('descripcion', 'like', "%{$search}%")
                      ->orWhere('codigo', 'like', "%{$search}%");
                });
            });
        }

        // Ordenamos por las más recientes primero
        $entradas = $query->orderByDesc('id')->paginate(15);

        return view('entradas.index', compact('entradas'));
    }

    /**
     * Formulario de creación.
     * OPTIMIZACIÓN: Ya no cargamos Producto::all() para no saturar la RAM.
     */
    public function create()
    {
        // Enviamos la vista sin productos, el JS se encarga de la búsqueda dinámica
        return view('entradas.create');
    }

    /**
     * Guarda la entrada y actualiza el stock automáticamente.
     */
    public function store(Request $request)
    {
        // 1. Validación estricta
        $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'cantidad'    => 'required|numeric|min:1',
            'motivo'      => 'required|string|max:255',
        ]);

        try {
            // Usamos una transacción o simplemente actualizamos (más seguro en producción)
            $producto = Producto::findOrFail($request->producto_id);

            // 2. Crear el registro de entrada
            Entrada::create([
                'producto_id' => $request->producto_id,
                'cantidad'    => $request->cantidad,
                'motivo'      => $request->motivo,
            ]);

            // 3. Sumar al stock actual
            $producto->increment('stock_actual', $request->cantidad);

            return redirect()->route('entradas.index')
                ->with('success', "Se han ingresado {$request->cantidad} unidades a: {$producto->descripcion}");

        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'No se pudo registrar la entrada: ' . $e->getMessage()]);
        }
    }

    /**
     * Las entradas de inventario no se deben editar ni borrar por integridad contable.
     */
    public function edit($id)
    {
        abort(403, 'Las entradas de inventario son registros permanentes y no se pueden editar.');
    }

    public function destroy($id)
    {
        abort(403, 'No se permite eliminar registros de entrada por seguridad de auditoría.');
    }
}