<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Fila;
use App\Models\Columna;
use App\Models\Nivel;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $productos = Producto::orderBy('id', 'asc')->paginate(10);
        return view('productos.index', compact('productos')); 
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categorias = Categoria::all();
        $filas = Fila::orderBy('nombre')->get();
        $columnas = Columna::orderBy('numero')->get();
        $niveles = Nivel::orderBy('numero')->get();
        return view('productos.create', compact('categorias','filas','columnas','niveles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'codigo' => 'required|unique:productos',
            'descripcion' => 'required',
            'precio_unitario' => 'required|numeric|min:0',
            'stock_actual' => 'required|numeric|min:0',
            'categoria_id' => 'nullable|exists:categorias,id',
            'ubicacion' => 'nullable|string|max:50',
            'unidad_medida' => 'nullable|string|max:50',
            'marca' => 'nullable|string|max:100',
            'fila_id'=>'nullable|exists:filas,id',
            'columna_id'=>'nullable|exists:columnas,id',
            'nivel_id'=>'nullable|exists:niveles,id',
        ]);

        if ($request->fila_id && $request->columna_id && $request->nivel_id) {
        $fila = Fila::find($request->fila_id);
        $columna = Columna::find($request->columna_id);
        $nivel = Nivel::find($request->nivel_id);

        // Formato: Ejemplo (A-1-1)
        $ubicacion = $fila->nombre . '-' . $columna->numero . '-' . $nivel->numero;

    } else {

        // SIN UBICACIÓN
        $ubicacion = null;
    }
        // Guardar producto
        Producto::create([
            'codigo'         => $request->codigo,
            'descripcion'    => $request->descripcion,
            'precio_unitario'=> $request->precio_unitario,
            'stock_actual'   => $request->stock_actual,
            'categoria_id'   => $request->categoria_id,
            'unidad_medida'  => $request->unidad_medida,
            'marca'          => $request->marca,
            'fila_id'        => $request->fila_id ?: null,
            'columna_id'     => $request->columna_id ?: null,
            'nivel_id'       => $request->nivel_id ?: null,
            'ubicacion'      => $ubicacion,
        ]);

        return redirect()->route('productos.index')->with('success', 'Producto creado correctamente.');
    }
    
    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $producto = Producto::findOrFail($id);
        return view('productos.show', compact('producto'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $producto = Producto::findOrFail($id);
        $categorias = Categoria::all();
        $filas = Fila::orderBy('nombre')->get();
        $columnas = Columna::orderBy('numero')->get();
        $niveles = Nivel::orderBy('numero')->get();
        return view('productos.edit', compact('producto','categorias','filas','columnas','niveles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Producto $producto)
{
    $request->validate([
        'codigo' => 'required|string',
        'descripcion' => 'required|string',
        'precio_unitario' => 'required|numeric|min:0',
        'stock_actual' => 'required|numeric|min:0',
        'categoria_id' => 'nullable|exists:categorias,id',
        'unidad_medida' => 'nullable|string|max:50',
        'marca' => 'nullable|string|max:100',
        'fila_id' => 'nullable|exists:filas,id',
        'columna_id' => 'nullable|exists:columnas,id',
        'nivel_id' => 'nullable|exists:niveles,id',
    ]);

    // Obtener relaciones
    $fila = Fila::find($request->fila_id);
    $columna = Columna::find($request->columna_id);
    $nivel = Nivel::find($request->nivel_id);

    // Calcular ubicación
    $ubicacion = null;
    if ($fila && $columna && $nivel) {
        $ubicacion = $fila->nombre . '-' . $columna->numero . '-' . $nivel->numero;
    }

    // Actualizar producto
    $producto->update([
        'codigo' => $request->codigo,
        'descripcion' => $request->descripcion,
        'precio_unitario' => $request->precio_unitario,
        'stock_actual' => $request->stock_actual,
        'categoria_id' => $request->categoria_id,
        'unidad_medida' => $request->unidad_medida,
        'marca' => $request->marca,
        'fila_id' => $request->fila_id,
        'columna_id' => $request->columna_id,
        'nivel_id' => $request->nivel_id,
        'ubicacion' => $ubicacion,
    ]);

    return redirect()
        ->route('productos.index')
        ->with('success', 'Producto actualizado correctamente.');
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $producto = Producto::findOrFail($id);
        $producto->delete();

        return redirect()->route('productos.index')->with('success', 'Producto eliminado correctamente.');
    }
    
}