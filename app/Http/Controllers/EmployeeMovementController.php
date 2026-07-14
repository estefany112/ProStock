<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\EmployeeMovement;
use Illuminate\Http\Request;

class EmployeeMovementController extends Controller
{
    public function index(Employee $employee)
    {
        abort_unless(auth()->user()->hasPermission('employee.view'), 403);

        $movements = $employee->movements()
            ->orderBy('date', 'desc')
            ->paginate(10);

        return view('employee_movements.index', compact(
            'employee',
            'movements'
        ));
    }


    public function create(Employee $employee)
    {
        abort_unless(auth()->user()->hasPermission('employee.edit'), 403);

        return view('employee_movements.create', compact('employee'));
    }


    public function store(Request $request, Employee $employee)
    {
        abort_unless(auth()->user()->hasPermission('employee.edit'), 403);

        $request->validate([
            'type' => 'required',
            'date' => 'required|date',
            'reason' => 'nullable|string',
        ]);


        $employee->movements()->create([
            'type' => $request->type,
            'date' => $request->date,
            'reason' => $request->reason,
            'created_by' => auth()->id(),
        ]);


        // Si es renuncia o despido desactivamos empleado
        if (in_array($request->type, ['RENUNCIA', 'DESPIDO'])) {

            $employee->update([
                'active' => false,
                'fecha_baja' => $request->date,
            ]);

        }


        return redirect()
            ->route('employee.movements.index', $employee)
            ->with('success', 'Movimiento registrado correctamente');
    }
}