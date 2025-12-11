<?php

namespace App\Http\Controllers;

use App\Models\Columna;
use Illuminate\Http\Request;

class ColumnaController extends Controller
{
    public function index()
    {
        $columnas = Columna::orderBy('numero')->get();
        return view('columnas.index', compact('columnas'));
    }

    public function create()
    {
        return view('columnas.create');
    }

    public function store(Request $request)
    {
        $request->validate(['numero'=>'required|string|max:10|unique:columnas,numero']);
        Columna::create(['numero'=>$request->numero]);
        return redirect()->route('columnas.index')->with('success','Columna creada.');
    }

    public function edit($id)
    {
        $columna = Columna::findOrFail($id);
        return view('columnas.edit', compact('columna'));
    }

    public function update(Request $request, $id)
    {
        $columna = Columna::findOrFail($id);
        $request->validate(['numero'=>'required|string|max:10|unique:columnas,numero,'.$columna->id]);
        $columna->update(['numero'=>$request->nombre]);
        return redirect()->route('columnas.index')->with('success','Columna actualizada.');
    }

    public function destroy($id)
    {
        $columna = Columna::findOrFail($id);
        $columna->delete();
        return redirect()->route('columnas.index')->with('success','Columna eliminada.');
    }
}
