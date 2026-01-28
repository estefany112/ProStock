<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Fila;
use App\Models\Columna;
use App\Models\Nivel;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;


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
    $rules = [
        'codigo' => 'required|unique:productos',
        'descripcion' => 'required',
        'stock_actual' => 'required|numeric|min:0',
        'categoria_id' => 'nullable|exists:categorias,id',
        'unidad_medida' => 'nullable|string|max:50',
        'marca' => 'nullable|string|max:100',
        'fila_id' => 'nullable|exists:filas,id',
        'columna_id' => 'nullable|exists:columnas,id',
        'nivel_id' => 'nullable|exists:niveles,id',
    ];

    if (auth()->user()->hasAnyRole(['admin','compras'])) {
        $rules['precio_unitario'] = 'required|numeric|min:0';
    }

    $request->validate($rules);

    // PRECIO SEGURO
    $precio = auth()->user()->hasAnyRole(['admin','compras'])
        ? $request->precio_unitario
        : 0;

    // UBICACIÓN
    $ubicacion = null;
        if ($request->fila_id) {
            $fila = Fila::find($request->fila_id);
            $ubicacion = $fila?->nombre;
        }

        if ($request->columna_id) {
            $columna = Columna::find($request->columna_id);
            $ubicacion .= $columna ? '-'.$columna->numero : '';
        }

        if ($request->nivel_id) {
            $nivel = Nivel::find($request->nivel_id);
            $ubicacion .= $nivel ? '-'.$nivel->numero : '';
        }

    Producto::create([
        'codigo' => $request->codigo,
        'descripcion' => $request->descripcion,
        'precio_unitario' => $precio,
        'stock_actual' => $request->stock_actual,
        'categoria_id' => $request->categoria_id,
        'unidad_medida' => $request->unidad_medida,
        'marca' => $request->marca,
        'fila_id' => $request->fila_id,
        'columna_id' => $request->columna_id,
        'nivel_id' => $request->nivel_id,
        'ubicacion' => $ubicacion,
    ]);

    return redirect()->route('productos.index')
        ->with('success', 'Producto creado correctamente.');
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
        $rules = [
            'codigo' => [
                'required',
                Rule::unique('productos')->ignore($producto->id),
            ],
            'descripcion' => 'required|string',
            'stock_actual' => 'required|numeric|min:0',
            'categoria_id' => 'nullable|exists:categorias,id',
            'unidad_medida' => 'nullable|string|max:50',
            'marca' => 'nullable|string|max:100',
            'fila_id' => 'nullable|exists:filas,id',
            'columna_id' => 'nullable|exists:columnas,id',
            'nivel_id' => 'nullable|exists:niveles,id',
        ];

        // SOLO ADMIN Y COMPRAS VALIDAN PRECIO
        if (auth()->user()->hasAnyRole(['admin','compras'])) {
            $rules['precio_unitario'] = 'required|numeric|min:0';
        }

        $request->validate($rules);

        // Datos base
        $data = $request->except('precio_unitario');

        // SOLO ADMIN Y COMPRAS ACTUALIZAN PRECIO
        if (auth()->user()->hasAnyRole(['admin','compras'])) {
            $data['precio_unitario'] = $request->precio_unitario;
        }

        // Ubicación
         $ubicacion = null;

        if ($request->fila_id) {
            $fila = Fila::find($request->fila_id);
            $ubicacion = $fila?->nombre;
        }

        if ($request->columna_id) {
            $columna = Columna::find($request->columna_id);
            $ubicacion .= $columna ? '-'.$columna->numero : '';
        }

        if ($request->nivel_id) {
            $nivel = Nivel::find($request->nivel_id);
            $ubicacion .= $nivel ? '-'.$nivel->numero : '';
        }

        $data['ubicacion'] = $ubicacion;

        $producto->update($data);

        return redirect()
            ->route('productos.index')
            ->with('success', 'Producto actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        abort_unless(auth()->user()->hasRole('admin'), 403);

        Producto::findOrFail($id)->delete();

        return redirect()->route('productos.index')
            ->with('success','Producto eliminado.');
    }
    
}