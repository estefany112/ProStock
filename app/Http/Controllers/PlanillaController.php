<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Planilla;
use App\Models\Employee;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\HoraExtra;

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
        'fecha_fin' => 'required|date|after:fecha_inicio',
    ]);

    // Verificar si existe planilla abierta
    $planillaAbierta = Planilla::where('estado', 'abierta')->exists();

    if ($planillaAbierta) {
        return back()->with('error', 'Debe cerrar la planilla abierta antes de crear una nueva.');
    }

    // Verificar que no exista solapamiento de fechas
    $existe = Planilla::where(function ($query) use ($request) {
        $query->where('fecha_inicio', '<=', $request->fecha_fin)
              ->where('fecha_fin', '>=', $request->fecha_inicio);
    })->exists();

    if ($existe) {
        return back()->with('error', 'Ya existe una planilla en ese rango de fechas.');
    }

    // Crear planilla
    $planilla = Planilla::create([
        'fecha_inicio' => $request->fecha_inicio,
        'fecha_fin' => $request->fecha_fin,
        'estado' => 'abierta'
    ]);

    $this->generarPlanilla($planilla);

    return redirect()->route('planillas.index')
                    ->with('success', 'Planilla generada correctamente');
}

private function generarPlanilla($planilla)
{
    if ($planilla->employees()->count() > 0) {
        return;
    }

    $inicio = Carbon::parse($planilla->fecha_inicio);
    $fin = Carbon::parse($planilla->fecha_fin);

    $empleados = Employee::activosEnRango($inicio, $fin)->get();

    foreach($empleados as $empleado){

        $salario = $empleado->salaryHistories()
            ->where(function($q) use ($fin){
                $q->whereNull('fecha_fin')
                ->orWhere('fecha_fin', '>=', $fin);
            })
            ->latest('id') 
            ->first();

        $salarioQuincenal = $salario
            ? $salario->salary / 2
            : $empleado->salary / 2;
        $bonificacion = 125;
        $igss = $salarioQuincenal * 0.0483;

        $horasExtras = HoraExtra::where('empleado_id', $empleado->id)
            ->whereBetween('fecha', [$inicio, $fin])
            ->sum('total');

        $liquido = ($salarioQuincenal + $bonificacion + $horasExtras) - $igss;

        $planilla->employees()->attach($empleado->id,[
            'salary_base_quincenal'=>$salarioQuincenal,
            'bonificacion'=>$bonificacion,
            'horas_extras'=>$horasExtras,
            'igss'=>$igss,
            'isr'=>0,
            'otros_descuentos'=>0,
            'liquido_recibir'=>$liquido
        ]);

    }

    // Copiar datos de la anterior planilla
    $this->copiarDatosAnterior($planilla->id);
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
    $planilla = Planilla::findOrFail($id);

    $inicio = \Carbon\Carbon::parse($planilla->fecha_inicio);
    $fin    = \Carbon\Carbon::parse($planilla->fecha_fin);

    // traer empleados activos
    $empleados = \App\Models\Employee::activosEnRango($inicio, $fin)->get();

    foreach ($empleados as $empleado) {

        // salario quincenal
        $salario = $empleado->salary_base / 2;

        // bonificación
        $bonificacion = 125;

        // igss
        $igss = $salario * 0.0483;

        // horas extras desde BD
        $horasExtras = \App\Models\HoraExtra::where('empleado_id', $empleado->id)
            ->whereBetween('fecha', [$inicio, $fin])
            ->sum('total');

        // liquido
        $liquido = ($salario + $bonificacion + $horasExtras) - $igss;

        // Guardar temporal (NO BD)
        $empleado->calc = (object)[
            'salario' => $salario,
            'bonificacion' => $bonificacion,
            'horas_extras' => $horasExtras,
            'igss' => $igss,
            'isr' => 0,
            'liquido' => $liquido
        ];
    }

    return view('planillas.show', compact('planilla','empleados'));
}

public function boleta($planillaId, $empleadoId)
{
    $planilla = Planilla::with('employees')->findOrFail($planillaId);

    $empleado = $planilla->employees()
        ->where('employee_id', $empleadoId)
        ->firstOrFail();

    $pdf = Pdf::loadView('planillas.boleta', compact('planilla', 'empleado'));

    $inicio = Carbon::parse($planilla->fecha_inicio);
    $fin    = Carbon::parse($planilla->fecha_fin);

    // Detectar tipo de período
    if ($inicio->day == 1 && $fin->day == 15) {
        $tipoPeriodo = 'Quincena';
    } elseif ($inicio->day == 16) {
        $tipoPeriodo = 'FinDeMes';
    } else {
        $tipoPeriodo = 'Periodo';
    }

    // Formato MesAño
    $mesAnio = $inicio->translatedFormat('M Y'); 
    // Ej: Feb 2026

    $nombreEmpleado = str_replace(' ', '', $empleado->name);

    return $pdf->download(
        "Boleta_{$nombreEmpleado}_{$tipoPeriodo}_{$mesAnio}.pdf"
    );
}

public function editarIsr($id)
{
    $planilla = Planilla::with('employees')->findOrFail($id);

    if ($planilla->estado === 'cerrada') {
        return back()->with('error', 'La planilla está cerrada.');
    }

    return view('planillas.editar_isr', compact('planilla'));
}

public function guardarIsr(Request $request, $id)
{
    $planilla = Planilla::with('employees')->findOrFail($id);

    foreach ($request->isr as $empleadoId => $isr) {

        $detalle = $planilla->employees()
            ->where('employee_id', $empleadoId)
            ->first();

        $salario = $detalle->pivot->salary_base_quincenal;
        $bonificacion = $detalle->pivot->bonificacion;
        $igss = $detalle->pivot->igss;
        $otros = $detalle->pivot->otros_descuentos;
        $horasExtras = $detalle->pivot->horas_extras;

        $liquido = ($salario + $bonificacion + $horasExtras)
                    - ($igss + $otros + $isr);

        $planilla->employees()->updateExistingPivot($empleadoId, [
            'isr' => $isr,
            'liquido_recibir' => $liquido
        ]);
    }

    return redirect()->route('planillas.show', $planilla->id)
            ->with('success', 'ISR actualizado correctamente.');
}

public function copiarDatosAnterior($id)
{
    $planillaActual = Planilla::with('employees')->findOrFail($id);

    if ($planillaActual->estado === 'cerrada') {
        return back()->with('error','La planilla está cerrada');
    }

    $planillaAnterior = Planilla::where('id','<',$planillaActual->id)
        ->orderBy('id','desc')
        ->first();

    if(!$planillaAnterior){
        return back()->with('error','No existe planilla anterior');
    }

    $planillaAnterior->load('employees');

    foreach($planillaAnterior->employees as $empleadoAnterior){

        $detalleActual = $planillaActual->employees()
            ->where('employee_id',$empleadoAnterior->id)
            ->first();

        if($detalleActual){

            $planillaActual->employees()->updateExistingPivot(
                $empleadoAnterior->id,
                [
                    'isr' => $empleadoAnterior->pivot->isr,
                    'otros_descuentos' => $empleadoAnterior->pivot->otros_descuentos
                ]
            );
        }
    }

    return back()->with('success','Datos copiados de la planilla anterior');
}

public function previewBoleta($planillaId, $empleadoId)
{
    $planilla = Planilla::findOrFail($planillaId);

    $empleado = $planilla->employees()
        ->where('employee_id', $empleadoId)
        ->firstOrFail();

    return view('planillas.boleta_preview', compact('planilla', 'empleado'));
}

    public function recalcular($id)
    {
        $planilla = Planilla::with('employees')->findOrFail($id);

        if ($planilla->estado === 'cerrada') {
            return back()->with('error', 'No se puede recalcular una planilla cerrada');
        }

        $inicio = Carbon::parse($planilla->fecha_inicio);
        $fin = Carbon::parse($planilla->fecha_fin);

        foreach ($planilla->employees as $empleado) {

            $salario = $empleado->salaryHistories()
                ->where(function($q) use ($fin){
                    $q->whereNull('fecha_fin')
                    ->orWhere('fecha_fin', '>=', $fin);
                })
                ->latest('id')
                ->first();

            $salarioQuincenal = $salario
                ? $salario->salary / 2
                : $empleado->salary / 2;

            $bonificacion = 125;
            $igss = $salarioQuincenal * 0.0483;
            $horasExtras = HoraExtra::where('empleado_id', $empleado->id)
                ->whereBetween('fecha', [$inicio, $fin])
                ->sum('total');

            // ACTUALIZA SIN BORRAR correlativo
            $liquido = ($salarioQuincenal + $bonificacion + $horasExtras)
            - ($igss + $empleado->pivot->isr + $empleado->pivot->otros_descuentos);

            $planilla->employees()->updateExistingPivot($empleado->id, [
                'salary_base_quincenal' => $salarioQuincenal,
                'bonificacion' => $bonificacion,
                'horas_extras' => $horasExtras,
                'igss' => $igss,
                'liquido_recibir' => $liquido
            ]);
        }

        return back()->with('success', 'Planilla recalculada sin perder correlativos');
    }
}
