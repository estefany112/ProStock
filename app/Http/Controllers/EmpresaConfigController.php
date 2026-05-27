<?php

namespace App\Http\Controllers;

use App\Models\EmpresaConfig;
use Illuminate\Http\Request;

class EmpresaConfigController extends Controller
{
    // Muestra el formulario con los datos actuales
    public function edit()
    {
        // Busca el ID 1, si no existe, crea un objeto vacío para que no rompa la vista
        $empresa = EmpresaConfig::find(1) ?? new EmpresaConfig();
        return view('configuracion.empresa', compact('empresa'));
    }

    // Procesa el guardado o la actualización
    public function update(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'nit' => 'required|string|max:50',
            'regimen_isr' => 'required|string|max:255',
            'direccion' => 'required|string',
            'telefono' => 'required|string|max:50',
            'correo' => 'required|email|max:255',
            'cuenta_bancaria' => 'required|string',
        ]);

        // La magia: updateOrCreate busca el ID 1. Si existe, lo actualiza. Si no, lo crea.
        EmpresaConfig::updateOrCreate(
            ['id' => 1],
            $request->all()
        );

        return redirect()->route('empresa.edit')->with('success', 'Datos de la empresa actualizados correctamente.');
    }
}