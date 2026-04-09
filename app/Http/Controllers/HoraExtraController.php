<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\HoraExtra;
use App\Models\Employee;

class HoraExtraController extends Controller
{
    public function formQuincena()
    {
        $empleados = Employee::all();
        return view('horas_extras.quincena', compact('empleados'));
    }

    public function storeQuincena(Request $request)
    {
        $empleado = Employee::findOrFail($request->empleado_id);

        foreach ($request->fechas as $index => $fecha) {

            $horas = $request->horas[$index];

            if (!$horas || $horas <= 0) {
                continue;
            }

            $dias_mes = Carbon::parse($fecha)->daysInMonth;

            $hora_base = $empleado->salary_base / $dias_mes / 8;

            $total = $horas * ($hora_base * 1.5);

            HoraExtra::create([
                'empleado_id' => $empleado->id,
                'fecha' => $fecha,
                'horas' => $horas,
                'salario_base' => $empleado->salary_base,
                'total' => $total
            ]);
        }

        return back()->with('success', 'Horas extras guardadas');
    }
}
