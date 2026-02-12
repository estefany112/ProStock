<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
public function index(Request $request)
{
    abort_unless(auth()->user()->hasPermission('employee.view'), 403);

    // Query base
    $query = Employee::query();

    // BUSCADOR
    if ($request->filled('search')) {

        $search = trim($request->search);

        $query->where(function ($q) use ($search) {

            $q->where('name', 'like', "%{$search}%")
              ->orWhere('dpi', 'like', "%{$search}%")
              ->orWhere('position', 'like', "%{$search}%")
              ->orWhere('salary_base', 'like', "%{$search}%")

              // Buscar por estado escrito
              ->orWhere(function ($sub) use ($search) {

                  if (strtolower($search) === 'activo') {
                      $sub->where('active', 1);
                  }

                  if (strtolower($search) === 'inactivo') {
                      $sub->where('active', 0);
                  }

              });
        });
    }

    // Orden por fecha de creación (desde el ultimo al más reciente)
    $employees = $query
        ->orderBy('created_at', 'asc')
        ->paginate(15)
        ->appends($request->query());

    return view('employees.index', compact('employees'));
}

    public function create()
    {
        abort_unless(auth()->user()->hasPermission('employee.create'), 403);

        return view('employees.create');
    }

    public function store(Request $request)
    {
        abort_unless(auth()->user()->hasPermission('employee.create'), 403);

        $request->validate([
            'name'         => 'required|string|max:255',
            'dpi'          => 'nullable|string|max:20',
            'position'     => 'required|string|max:100',
            'salary_base'  => 'required|numeric|min:0',
        ]);

        Employee::create($request->all());

        return redirect()
            ->route('employees.index')
            ->with('success', 'Empleado creado correctamente');
    }

    public function edit(Employee $employee)
    {
        abort_unless(auth()->user()->hasPermission('employee.edit'), 403);

        return view('employees.edit', compact('employee'));
    }

    public function update(Request $request, Employee $employee)
    {
        abort_unless(auth()->user()->hasPermission('employee.edit'), 403);

        $request->validate([
            'name'         => 'required|string|max:255',
            'dpi'          => 'nullable|string|max:20',
            'position'     => 'required|string|max:100',
            'salary_base'  => 'required|numeric|min:0',
            'active'       => 'required|boolean',
        ]);

        $employee->update($request->all());

        return redirect()
            ->route('employees.index')
            ->with('success', 'Empleado actualizado correctamente');
    }

    public function toggle(Employee $employee)
    {
        abort_unless(auth()->user()->hasPermission('employee.disable'), 403);

        $employee->update([
            'active' => !$employee->active
        ]);

        return back()->with('success', 'Estado del empleado actualizado');
    }
}

