<?php

namespace App\Http\Controllers;

use App\Models\Entrada;
use App\Models\Producto;
use Illuminate\Http\Request;

class EntradaController extends Controller
{
     /**
     * Mostrar el listado de todas las entradas.
     */
    public function index(Request $request)
    {
        $query = Entrada::with([
            'producto',
            'producto.categoria',
            'producto.fila',
            'producto.columna',
            'producto.nivel',
        ]);

        // 🔍 BUSCADOR
        if ($request->filled('search')) {
            $search = trim($request->search);

            $query->where(function ($q) use ($search) {

                // 🔹 Motivo de la entrada
                $q->where('motivo', 'like', "%{$search}%")

                // 🔹 Datos del producto
                ->orWhereHas('producto', function ($p) use ($search) {
                    $p->where('descripcion', 'like', "%{$search}%")
                    ->orWhere('codigo', 'like', "%{$search}%")
                    ->orWhere('marca', 'like', "%{$search}%")
                    ->orWhere('ubicacion', 'like', "%{$search}%");
                })

                // 🔹 Categoría
                ->orWhereHas('producto.categoria', function ($c) use ($search) {
                    $c->where('nombre', 'like', "%{$search}%");
                })

                // 🔹 Ubicación relacional
                ->orWhereHas('producto.fila', function ($f) use ($search) {
                    $f->where('nombre', 'like', "%{$search}%");
                })
                ->orWhereHas('producto.columna', function ($c) use ($search) {
                    $c->where('numero', 'like', "%{$search}%");
                })
                ->orWhereHas('producto.nivel', function ($n) use ($search) {
                    $n->where('numero', 'like', "%{$search}%");
                });
            });
        }

        $entradas = $query
            ->orderByDesc('id')
            ->paginate(10);

        return view('entradas.index', compact('entradas'));
    }

    /**
     * Mostrar el formulario para crear una nueva entrada.
     */
    public function create()
    {
        // Obtener todos los productos disponibles
        $productos = Producto::all();
        return view('entradas.create', compact('productos'));
    }

    /**
     * Almacenar una nueva entrada.
     */
    public function store(Request $request)
    {
        $request->validate([
            'producto_id' => 'required|exists:productos,id', // Verifica que el producto exista
            'cantidad' => 'required|numeric|min:1',
            'motivo' => 'required|string',
        ]);

        // Crear la entrada de inventario
        $entrada = Entrada::create([
            'producto_id' => $request->producto_id,
            'cantidad' => $request->cantidad,
            'motivo' => $request->motivo,
        ]);

        // Actualizar el stock del producto relacionado
        $producto = Producto::find($request->producto_id);
        $producto->stock_actual += $request->cantidad;
        $producto->save();

        return redirect()->route('entradas.index')->with('success', 'Entrada registrada correctamente.');
    }


    /**
     * Mostrar el formulario para editar una entrada.
     */
    public function edit($id)
    {
        $entrada = Entrada::findOrFail($id);
        $productos = Producto::all();
        return view('entradas.edit', compact('entrada', 'productos'));
    }

    /**
     * Actualizar una entrada.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'cantidad' => 'required|numeric|min:1',
            'motivo' => 'required|string',
        ]);

        $entrada = Entrada::findOrFail($id);
        $entrada->update([
            'producto_id' => $request->producto_id,
            'cantidad' => $request->cantidad,
            'motivo' => $request->motivo,
        ]);

        // Actualizar el stock del producto
        $producto = Producto::find($request->producto_id);
        $producto->stock_actual += $request->cantidad;
        $producto->save();

        return redirect()->route('entradas.index')->with('success', 'Entrada actualizada correctamente.');
    }

    /**
     * Eliminar una entrada.
     */
    public function destroy($id)
    {
        $entrada = Entrada::findOrFail($id);
        $entrada->delete();

        // Redirigir al listado de entradas con mensaje de éxito
        return redirect()->route('entradas.index')->with('success', 'Entrada eliminada correctamente.');
    }
}