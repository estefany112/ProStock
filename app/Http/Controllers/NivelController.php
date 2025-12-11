<?php

namespace App\Http\Controllers;

use App\Models\Nivel;
use Illuminate\Http\Request;

class NivelController extends Controller
{
    public function index()
    {
        $niveles = Nivel::orderBy('numero')->get();
        return view('niveles.index', compact('niveles'));
    }

    public function create()
    {
        return view('niveles.create');
    }

    public function store(Request $request)
    {
        $request->validate(['numero'=>'required|string|max:10|unique:niveles,numero']);
        Nivel::create(['numero'=>$request->numero]);
        return redirect()->route('niveles.index')->with('success','Nivel creada.');
    }

    public function edit($id)
    {
        $nivel = Nivel::findOrFail($id);
        return view('niveles.edit', compact('nivel'));
    }

    public function update(Request $request, $id)
    {
        $nivel = Nivel::findOrFail($id);
        $request->validate(['nombre'=>'required|string|max:10|unique:niveles,nombre,'.$nivel->id]);
        $nivel->update(['nombre'=>$request->nombre]);
        return redirect()->route('niveles.index')->with('success','Nivel actualizada.');
    }

    public function destroy($id)
    {
        $nivel = Nivel::findOrFail($id);
        $nivel->delete();
        return redirect()->route('niveles.index')->with('success','Nivel eliminada.');
    }
}
