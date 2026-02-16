<?php

namespace App\Http\Controllers;

use App\Models\Solicitud;
use App\Models\SolicitudDetalle;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SolicitudController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | 1️⃣ LISTAR SOLICITUDES
    |--------------------------------------------------------------------------
    */
    public function index()
    {
        $user = auth()->user();

        if ($user->roles->pluck('name')->contains('almacen')) {

            // Almacén solo ve aprobadas, entregadas o devueltas
            $solicitudes = Solicitud::with('empleado')
                ->whereIn('estado', ['aprobado', 'entregado', 'devuelto'])
                ->latest()
                ->get();

        } else {

            // Admin y supervisor ven todo
            $solicitudes = Solicitud::with('empleado')
                ->latest()
                ->get();
        }

        return view('solicitudes.index', compact('solicitudes'));
    }

    /*
    |--------------------------------------------------------------------------
    | 2️⃣ FORMULARIO CREAR SOLICITUD
    |--------------------------------------------------------------------------
    */
    public function create()
    {
        $empleados = Employee::where('active', 1)->get();

        return view('solicitudes.create', compact('empleados'));
    }

    /*
    |--------------------------------------------------------------------------
    | 3️⃣ GUARDAR SOLICITUD
    |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        $request->validate([
            'empleado_id' => 'required|exists:employees,id',
            'descripcion.*' => 'required|string',
            'cantidad.*' => 'required|integer|min:1',
        ]);

        $solicitud = Solicitud::create([
            'empleado_id' => $request->empleado_id,
            'observacion' => $request->observacion,
            'estado' => 'pendiente',
        ]);

        foreach ($request->descripcion as $index => $descripcion) {
            SolicitudDetalle::create([
                'solicitud_id' => $solicitud->id,
                'descripcion' => $descripcion,
                'cantidad' => $request->cantidad[$index],
            ]);
        }

        return redirect()->route('solicitudes.index')
            ->with('success', 'Solicitud creada correctamente.');
    }

    /*
    |--------------------------------------------------------------------------
    | 4️⃣ APROBAR SOLICITUD (ADMIN)
    |--------------------------------------------------------------------------
    */
    public function aprobar($id)
    {
        $solicitud = Solicitud::findOrFail($id);

        $solicitud->update([
            'estado' => 'aprobado',
            'aprobado_por' => Auth::id(),
            'fecha_aprobacion' => now(),
        ]);

        return back()->with('success', 'Solicitud aprobada.');
    }

    /*
    |--------------------------------------------------------------------------
    | 5️⃣ RECHAZAR SOLICITUD (ADMIN)
    |--------------------------------------------------------------------------
    */
    public function rechazar(Request $request, $id)
    {
        $solicitud = Solicitud::findOrFail($id);

        $solicitud->update([
            'estado' => 'rechazado',
            'comentario_admin' => $request->comentario_admin,
            'aprobado_por' => Auth::id(),
            'fecha_aprobacion' => now(),
        ]);

        return back()->with('success', 'Solicitud rechazada.');
    }

    /*
    |--------------------------------------------------------------------------
    | 6️⃣ MARCAR COMO ENTREGADO (BODEGA)
    |--------------------------------------------------------------------------
    */
    public function entregar($id)
    {
        $solicitud = Solicitud::findOrFail($id);

        $solicitud->update([
            'estado' => 'entregado',
            'entregado_por' => Auth::id(),
            'fecha_entrega' => now(),
        ]);

        return back()->with('success', 'Solicitud marcada como entregada.');
    }

    /*
    |--------------------------------------------------------------------------
    | 7️⃣ MARCAR COMO DEVUELTO (BODEGA)
    |--------------------------------------------------------------------------
    */
    public function devolver($id)
    {
        $solicitud = Solicitud::findOrFail($id);

        $solicitud->update([
            'estado' => 'devuelto',
        ]);

        return back()->with('success', 'Solicitud marcada como devuelta.');
    }

    /*
    |--------------------------------------------------------------------------
    | 8️⃣ VER DETALLE
    |--------------------------------------------------------------------------
    */
    public function show($id)
    {
        $solicitud = Solicitud::with(['empleado', 'detalles'])
            ->findOrFail($id);

        return view('solicitudes.show', compact('solicitud'));
    }
}