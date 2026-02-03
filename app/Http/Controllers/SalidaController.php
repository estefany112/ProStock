<?php

namespace App\Http\Controllers;

use App\Models\Salida;
use App\Models\Producto;
use Illuminate\Http\Request;

class SalidaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Salida::with([
            'producto',
            'producto.categoria',
            'producto.fila',
            'producto.columna',
            'producto.nivel',
        ]);

        // BUSCADOR
        if ($request->filled('search')) {
            $search = trim($request->search);

            $query->where(function ($q) use ($search) {

                // Motivo de salida
                $q->where('motivo', 'like', "%{$search}%")

                // Producto
                ->orWhereHas('producto', function ($p) use ($search) {
                    $p->where('descripcion', 'like', "%{$search}%")
                    ->orWhere('codigo', 'like', "%{$search}%")
                    ->orWhere('marca', 'like', "%{$search}%")
                    ->orWhere('ubicacion', 'like', "%{$search}%");
                })

                // Categoría
                ->orWhereHas('producto.categoria', function ($c) use ($search) {
                    $c->where('nombre', 'like', "%{$search}%");
                })

                // Ubicación relacional
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

        $salidas = $query
            ->orderByDesc('id')
            ->paginate(10);

        return view('salidas.index', compact('salidas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $productos = Producto::all();
        return view('salidas.create', compact('productos'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'cantidad' => 'required|numeric|min:1',
            'motivo' => 'required|string',
        ]);

        $producto = Producto::find($request->producto_id);

        if ($producto->stock_actual < $request->cantidad) {
            return redirect()->back()
                ->with('error', 'No hay suficiente stock para esta salida.')
                ->withInput();
        }

        // Restar stock
        $producto->stock_actual -= $request->cantidad;
        $producto->save();

        Salida::create([
            'producto_id' => $request->producto_id,
            'cantidad' => $request->cantidad,
            'motivo' => $request->motivo,
            'fecha_salida' => now(),
        ]);

        return redirect()->route('salidas.index')->with('success', 'Salida registrada correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $salida = Salida::findOrFail($id);
        $productos = Producto::all();

        return view('salidas.edit', compact('salida', 'productos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'cantidad' => 'required|numeric|min:1',
            'motivo' => 'required|string',
        ]);

        $salida = Salida::findOrFail($id);
        $producto = Producto::find($salida->producto_id);

        // devolver el stock de la salida anterior
        $producto->stock_actual += $salida->cantidad;

        // validar stock con nueva cantidad
        if ($producto->stock_actual < $request->cantidad) {
            return redirect()->back()->with('error', 'Stock insuficiente para aplicar este cambio.');
        }

        // aplicar la nueva salida
        $producto->stock_actual -= $request->cantidad;
        $producto->save();

        $salida->update([
            'cantidad' => $request->cantidad,
            'motivo' => $request->motivo,
        ]);

        return redirect()->route('salidas.index')->with('success', 'Salida actualizada correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $salida = Salida::findOrFail($id);
        $producto = Producto::find($salida->producto_id);

        // devolver al producto la cantidad eliminada
        $producto->stock_actual += $salida->cantidad;
        $producto->save();

        $salida->delete();

        return redirect()->route('salidas.index')->with('success', 'Salida eliminada correctamente.');
    }
}
