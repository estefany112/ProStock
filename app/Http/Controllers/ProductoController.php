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
use Illuminate\Support\Facades\Storage;


class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    // Añadimos 'with' para traer las relaciones en una sola consulta
    $query = Producto::with(['categoria', 'fila', 'columna', 'nivel']);

    if ($request->filled('search')) {
        $search = trim($request->search);

        $query->where(function ($q) use ($search) {
            // Campos directos de la tabla productos
            $q->where('descripcion', 'like', "%{$search}%")
              ->orWhere('codigo', 'like', "%{$search}%")
              ->orWhere('marca', 'like', "%{$search}%")
              ->orWhere('ubicacion', 'like', "%{$search}%");

            // Búsquedas en relaciones
            $q->orWhereHas('categoria', fn($c) => $c->where('nombre', 'like', "%{$search}%"))
              ->orWhereHas('fila', fn($f) => $f->where('nombre', 'like', "%{$search}%"))
              ->orWhereHas('columna', fn($c) => $c->where('numero', 'like', "%{$search}%"))
              ->orWhereHas('nivel', fn($n) => $n->where('numero', 'like', "%{$search}%"));
        });
    }

    $productos = $query
        ->orderBy('descripcion')
        ->paginate(15) // Puedes subirlo a 15 o 20 ahora que es más rápido
        ->withQueryString();

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
        'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        'stock_actual' => 'required|numeric|min:0',
        'categoria_id' => 'nullable|exists:categorias,id',
        'unidad_medida' => 'nullable|string|max:50',
        'marca' => 'nullable|string|max:100',
        'fila_id' => 'nullable|exists:filas,id',
        'columna_id' => 'nullable|exists:columnas,id',
        'nivel_id' => 'nullable|exists:niveles,id',
    ];

    if (auth()->user()->hasAnyRole(['admin','compras', 'almacen'])) {
        $rules['precio_unitario'] = 'required|numeric|min:0';
    }

    $request->validate($rules);

    // PRECIO SEGURO
    $precio = auth()->user()->hasAnyRole(['admin','compras', 'almacen'])
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

        // GUARDAR IMAGEN
        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')
                ->store('productos', 'public');
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
        'image' => $imagePath,
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
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'stock_actual' => 'required|numeric|min:0',
            'categoria_id' => 'nullable|exists:categorias,id',
            'unidad_medida' => 'nullable|string|max:50',
            'marca' => 'nullable|string|max:100',
            'fila_id' => 'nullable|exists:filas,id',
            'columna_id' => 'nullable|exists:columnas,id',
            'nivel_id' => 'nullable|exists:niveles,id',
        ];

        // SOLO ADMIN, COMPRAS Y ALMACEN VALIDAN PRECIO
        if (auth()->user()->hasAnyRole(['admin','compras', 'almacen'])) {
            $rules['precio_unitario'] = 'required|numeric|min:0';
        }

        $request->validate($rules);

        // Datos base
        $data = $request->except('precio_unitario');

        // SOLO ADMIN, COMPRAS Y ALMACEN ACTUALIZAN PRECIO
        if (auth()->user()->hasAnyRole(['admin','compras', 'almacen'])) {
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

        // ACTUALIZAR IMAGEN
        if ($request->hasFile('image')) {

            // eliminar anterior
            if ($producto->image) {
                Storage::disk('public')->delete($producto->image);
            }

            $data['image'] = $request->file('image')
                ->store('productos', 'public');
        }

        $producto->update($data);

        return redirect()
            ->route('productos.index', [
            'search' => $request->search,
            'page' => $request->page
        ])
        ->with('success', 'Producto actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        abort_unless(auth()->user()->hasRole('admin'), 403);

        $producto = Producto::findOrFail($id);
        
        // Eliminar imagen si existe
        if ($producto->image) {
            Storage::disk('public')->delete($producto->image);
        }
        $producto->delete();

        return redirect()->route('productos.index')
            ->with('success','Producto eliminado.');
    }
    
    // Busca este nombre en tu ProductoController.php
    public function buscar(Request $request)
    {
        $search = $request->search;

        // Si el buscador está vacío, no devolvemos nada para ahorrar recursos
        if (!$search) {
            return response()->json([]);
        }

        $productos = Producto::where('descripcion', 'like', "%$search%")
            ->orWhere('codigo', 'like', "%$search%")
            // Esto es lo nuevo: solo pedimos 4 datos, no los 15 o 20 que tiene la tabla
            ->select('id', 'codigo', 'descripcion', 'stock_actual') 
            ->limit(10)
            ->get();

        return response()->json($productos);
    }
    
}