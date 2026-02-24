<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Planilla;
use App\Models\Employee;
use Barryvdh\DomPDF\Facade\Pdf;

class PlanillaController extends Controller
{
    public function index()
    {
        $planillas = Planilla::orderBy('fecha_inicio', 'desc')->get();
        return view('planillas.index', compact('planillas'));
    }

    public function store(Request $request)
    {
        // 1️⃣ Validar datos
        $request->validate([
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after:fecha_inicio',
        ]);

        // 2️⃣ Crear planilla
        $planilla = Planilla::create([
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin,
            'estado' => 'abierta'
        ]);

        // 3️⃣ Generar automáticamente los cálculos
        $this->generarPlanilla($planilla);

        return redirect()->route('planillas.index')
                        ->with('success', 'Planilla generada correctamente');
    }

private function generarPlanilla($planilla)
{
    if ($planilla->employees()->count() > 0) {
        return;
    }

    $empleados = Employee::where('active', 1)->get();

    foreach ($empleados as $empleado) {

        $salarioQuincenal = $empleado->salary_base / 2;
        $bonificacion = 125;
        $igss = $salarioQuincenal * 0.0483;

        // 🔹 ISR básico ejemplo (solo si supera cierto monto)
        $isr = 0;

        if ($salarioQuincenal > 3000) {
            $isr = $salarioQuincenal * 0.05; // ejemplo simple
        }

        $otrosDescuentos = 0;

        $liquido = ($salarioQuincenal + $bonificacion)
                    - ($igss + $isr + $otrosDescuentos);

        $planilla->employees()->attach($empleado->id, [
            'salary_base_quincenal' => $salarioQuincenal,
            'bonificacion' => $bonificacion,
            'igss' => $igss,
            'isr' => $isr,
            'otros_descuentos' => $otrosDescuentos,
            'liquido_recibir' => $liquido,
        ]);
    }
}

public function cerrar($id)
{
    $planilla = Planilla::findOrFail($id);

    if ($planilla->estado == 'cerrada') {
        return back()->with('error', 'La planilla ya está cerrada');
    }

    $planilla->estado = 'cerrada';
    $planilla->save();

    return back()->with('success', 'Planilla cerrada correctamente');
}

public function show($id)
{
    $planilla = Planilla::with('employees')->findOrFail($id);
    return view('planillas.show', compact('planilla'));
}

public function boleta($planillaId, $empleadoId)
{
    $planilla = Planilla::findOrFail($planillaId);

    $empleado = $planilla->employees()
        ->where('employee_id', $empleadoId)
        ->firstOrFail();

    $pdf = Pdf::loadView('planillas.boleta', compact('planilla', 'empleado'));

    return $pdf->download('boleta_'.$empleado->name.'.pdf');
}

}
