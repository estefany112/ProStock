<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    // LISTADO
    public function index(Request $request)
    {
        $search = trim($request->get('search', ''));

        $clientes = Cliente::query()

            ->when($search, function ($qry) use ($search) {

                $qry->where(function ($w) use ($search) {

                    $w->where('nombre', 'like', "%{$search}%")
                    ->orWhere('empresa', 'like', "%{$search}%")
                    ->orWhere('nit', 'like', "%{$search}%")
                    ->orWhere('telefono', 'like', "%{$search}%")
                    ->orWhere('correo', 'like', "%{$search}%")
                    ->orWhere('direccion', 'like', "%{$search}%");

                });

            })

            ->orderBy('nombre')

            ->paginate(10)

            ->withQueryString();

        return view('clientes.index', compact('clientes', 'search'));
    }

    // FORMULARIO
    public function create()
    {
        return view('clientes.create');
    }

    // GUARDAR
    public function store(Request $request)
    {
        $request->validate([

            'tipo_cliente' => 'required',
            'nombre' => 'required|max:150',
            'empresa' => 'nullable|max:150',
            'nit' => 'nullable|max:50',
            'telefono' => 'nullable|max:50',
            'correo' => 'nullable|email',
            'direccion' => 'nullable',

        ]);

        Cliente::create([

            'tipo_cliente' => $request->tipo_cliente,
            'nombre' => $request->nombre,
            'empresa' => $request->empresa,
            'nit' => $request->nit,
            'telefono' => $request->telefono,
            'correo' => $request->correo,
            'direccion' => $request->direccion,

        ]);

        return redirect()
            ->route('clientes.index')
            ->with('success', 'Cliente creado correctamente');
    }

    // VER CLIENTE
    public function show(Cliente $cliente)
    {
        return view('clientes.show', compact('cliente'));
    }

    // FORM EDITAR
    public function edit(Cliente $cliente)
    {
        return view('clientes.edit', compact('cliente'));
    }

    // ACTUALIZAR
    public function update(Request $request, Cliente $cliente)
    {
        $request->validate([

            'tipo_cliente' => 'required',
            'nombre' => 'required|max:150',
            'empresa' => 'nullable|max:150',
            'nit' => 'nullable|max:50',
            'telefono' => 'nullable|max:50',
            'correo' => 'nullable|email',
            'direccion' => 'nullable',

        ]);

        $cliente->update($request->all());

        return redirect()
            ->route('clientes.index')
            ->with('success', 'Cliente actualizado correctamente');
    }

    // ELIMINAR
    public function destroy(Cliente $cliente)
    {
        $cliente->delete();

        return redirect()
            ->route('clientes.index')
            ->with('success', 'Cliente eliminado correctamente');
    }
}