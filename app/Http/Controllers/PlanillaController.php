<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Planilla;

class PlanillaController extends Controller
{
    public function index()
    {
        $planillas = Planilla::orderBy('fecha_inicio', 'desc')->get();
        return view('planillas.index', compact('planillas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
        ]);

        Planilla::create($request->all());

        return redirect()->back();
    }

}
