<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Anticipo;
use App\Models\Employee;
use Carbon\Carbon;

class AnticipoController extends Controller
{
    public function formQuincena()
    {
        $empleados = Employee::all();

        return view('anticipos.quincena', compact('empleados'));
    }

    public function storeQuincena(Request $request)
    {
        $request->validate([
            'empleado_id' => 'required|exists:employees,id',
            'fecha' => 'required|date',
            'monto' => 'required|numeric|min:0',
            'descripcion' => 'nullable|string'
        ]);

        Anticipo::create([
            'employee_id' => $request->empleado_id,
            'fecha' => $request->fecha,
            'monto' => $request->monto,
            'descripcion' => $request->descripcion ?? 'Anticipo de quincena',
            'estado' => 'pendiente'
        ]);

        return back()->with('success', 'Anticipo registrado correctamente');
    }

    public function historial(Request $request)
    {
        $inicio = $request->inicio;
        $fin = $request->fin;

        $anticipos = Anticipo::with('empleado')

            ->when($inicio, function ($query) use ($inicio) {
                $query->whereDate('fecha', '>=', $inicio);
            })

            ->when($fin, function ($query) use ($fin) {
                $query->whereDate('fecha', '<=', $fin);
            })

            ->orderBy('fecha', 'desc')
            ->get();

        return view('anticipos.historial', compact(
            'anticipos',
            'inicio',
            'fin'
        ));
    }

    public function detalle($empleado, $inicio, $fin)
    {
        $anticipos = Anticipo::where('employee_id', $empleado)
            ->whereBetween('fecha', [$inicio, $fin])
            ->get();

        return view('anticipos.detalle', compact(
            'anticipos',
            'inicio',
            'fin'
        ));
    }
}