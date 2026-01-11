<?php

namespace App\Http\Controllers;

use App\Models\Fila;
use Illuminate\Http\Request;

class FilaController extends Controller
{
    public function index()
    {
        $filas = Fila::orderBy('nombre')->get();
        return view('filas.index', compact('filas'));
    }

    public function create()
    {
        return view('filas.create');
    }

    public function store(Request $request)
    {
        $request->validate(['nombre'=>'required|string|max:10|unique:filas,nombre']);
        Fila::create(['nombre'=>$request->nombre]);
        return redirect()->route('filas.index')->with('success','Fila creada.');
    }

    public function edit($id)
    {
        $fila = Fila::findOrFail($id);
        return view('filas.edit', compact('fila'));
    }

    public function update(Request $request, $id)
    {
        $fila = Fila::findOrFail($id);
        $request->validate(['nombre'=>'required|string|max:10|unique:filas,nombre,'.$fila->id]);
        $fila->update(['nombre'=>$request->nombre]);
        return redirect()->route('filas.index')->with('success','Fila actualizada.');
    }

    public function destroy($id)
    {
        $fila = Fila::findOrFail($id);
        $fila->delete();
        return redirect()->route('filas.index')->with('success','Fila eliminada.');
    }
}
