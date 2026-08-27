<?php

namespace App\Http\Controllers;

use App\Models\Vehiculo;
use Illuminate\Http\Request;

class VehiculoController extends Controller
{
    public function index()
    {
        $vehiculos = Vehiculo::orderByRaw("
                CASE
                    WHEN numero_interno LIKE 'V-%' THEN 1
                    WHEN numero_interno LIKE 'M-%' THEN 2
                    ELSE 3
                END
            ")
            ->orderByRaw("CAST(SUBSTRING(numero_interno, 3) AS UNSIGNED)")
            ->get();

        return view('vehiculos.index', compact('vehiculos'));
    }

    public function create()
    {
        return view('vehiculos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'numero_interno' => 'required|string|max:20|unique:vehiculos,numero_interno',
            'tipo' => 'required|string|max:30',
            'placa' => 'required|string|max:20|unique:vehiculos,placa',
            'marca' => 'required|string|max:100',
            'anio' => 'required|integer',
            'color' => 'required|string|max:50',
        ]);

        Vehiculo::create([
            'numero_interno' => $request->numero_interno,
            'tipo' => $request->tipo,
            'placa' => $request->placa,
            'marca' => $request->marca,
            'anio' => $request->anio,
            'color' => $request->color,
        ]);

        return redirect()
            ->route('vehiculos.index')
            ->with('success', 'Vehículo registrado correctamente.');
    }

    public function edit(Vehiculo $vehiculo)
    {
        return view('vehiculos.edit', compact('vehiculo'));
    }

    public function update(Request $request, Vehiculo $vehiculo)
    {
        $request->validate([
            'numero_interno' => 'required|string|max:20|unique:vehiculos,numero_interno,' . $vehiculo->id,
            'tipo' => 'required|string|max:30',
            'placa' => 'required|string|max:20|unique:vehiculos,placa,' . $vehiculo->id,
            'marca' => 'required|string|max:100',
            'anio' => 'required|integer',
            'color' => 'required|string|max:50',
        ]);

        $vehiculo->update([
            'numero_interno' => $request->numero_interno,
            'tipo' => $request->tipo,
            'placa' => $request->placa,
            'marca' => $request->marca,
            'anio' => $request->anio,
            'color' => $request->color,
        ]);

        return redirect()
            ->route('vehiculos.index')
            ->with('success', 'Vehículo actualizado correctamente.');
    }

    public function destroy(Vehiculo $vehiculo)
    {
        $vehiculo->delete();

        return redirect()
            ->route('vehiculos.index')
            ->with('success', 'Vehículo eliminado correctamente.');
    }
}