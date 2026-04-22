<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\HoraExtra;
use App\Models\Employee;
use Illuminate\Support\Facades\DB;

class HoraExtraController extends Controller
{
    public function formQuincena()
    {
        $empleados = Employee::all();
        return view('horas_extras.quincena', compact('empleados'));
    }

    public function storeQuincena(Request $request)
{
    $request->validate([
        'empleado_id' => 'required|exists:employees,id',
        'horas.*' => 'nullable|numeric|min:0'
    ]);

    $empleado = Employee::findOrFail($request->empleado_id);

    foreach ($request->fechas as $index => $fecha) {

    $horas = $request->horas[$index];

    if (!$horas || $horas <= 0) {
        continue;
    }

    // VALIDAR PLANILLA CERRADA
    $planillaCerrada = \App\Models\Planilla::where('estado','cerrada')
        ->where('fecha_inicio','<=',$fecha)
        ->where('fecha_fin','>=',$fecha)
        ->exists();

    if($planillaCerrada){
        return back()->with('error', "No se puede modificar horas del día $fecha porque la planilla está cerrada");
    }

    // CALCULO
    $hora_base = $empleado->salary_base / 30 / 8;
    $total = $horas * ($hora_base * 1.5);

    // GUARDAR
    \App\Models\HoraExtra::updateOrCreate(
        [
            'empleado_id' => $request->empleado_id,
            'fecha' => $fecha
        ],
        [
            'horas' => $horas,
            'salario_base' => $empleado->salary_base,
            'total' => $total
        ]
    );

    // ACTUALIZAR PLANILLA EN ESA MISMA ITERACIÓN
    $planilla = \App\Models\Planilla::where('estado','abierta')
        ->where('fecha_inicio','<=',$fecha)
        ->where('fecha_fin','>=',$fecha)
        ->first();

    if($planilla){

        $inicio = \Carbon\Carbon::parse($planilla->fecha_inicio);
        $fin    = \Carbon\Carbon::parse($planilla->fecha_fin);

        $horasExtras = \App\Models\HoraExtra::where('empleado_id', $empleado->id)
            ->whereBetween('fecha', [$inicio, $fin])
            ->sum('total');

        $detalle = $planilla->employees()
            ->where('employee_id', $empleado->id)
            ->first();

        if($detalle){

            $salario = $detalle->pivot->salary_base_quincenal;
            $bonificacion = $detalle->pivot->bonificacion;
            $igss = $detalle->pivot->igss;
            $isr = $detalle->pivot->isr;
            $otros = $detalle->pivot->otros_descuentos;

            $liquido = ($salario + $bonificacion + $horasExtras)
                - ($igss + $isr + $otros);

            $planilla->employees()->updateExistingPivot($empleado->id, [
                'horas_extras' => $horasExtras,
                'liquido_recibir' => $liquido
            ]);
        }
    }
}
return back()->with('success', 'Horas extras guardadas correctamente');
}
    public function historial(Request $request)
    {
        // 1. Obtener fechas (si no envían, usar mes actual)
        $inicio = $request->inicio ?? now()->startOfMonth()->toDateString();
        $fin    = $request->fin ?? now()->endOfMonth()->toDateString();

        // 2. Agrupar datos
        $datos = HoraExtra::select(
            'empleado_id',
            DB::raw('SUM(horas) as total_horas'),
            DB::raw('SUM(total) as total_pago')
        )
        ->whereBetween('fecha', [$inicio, $fin])
        ->groupBy('empleado_id')
        ->with('empleado') // relación
        ->get();

        // 3. Enviar a vista
        return view('horas_extras.historial', compact('datos','inicio','fin'));
    }

    public function detalle($empleadoId, $inicio, $fin)
    {
        $empleado = Employee::findOrFail($empleadoId);

        $registros = HoraExtra::where('empleado_id',$empleadoId)
            ->whereBetween('fecha', [$inicio, $fin])
            ->get();

        return view('horas_extras.detalle', compact('empleado','registros'));
    }

    private function actualizarPlanilla($fechas)
    {
        foreach ($fechas as $fecha) {

            $planilla = \App\Models\Planilla::where('estado','abierta')
                ->where('fecha_inicio','<=',$fecha)
                ->where('fecha_fin','>=',$fecha)
                ->first();

            if($planilla){
                app(\App\Http\Controllers\PlanillaController::class)
                    ->recalcular($planilla->id);
            }
        }
    }
}
