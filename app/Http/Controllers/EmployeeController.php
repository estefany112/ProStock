<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index()
    {
        abort_unless(auth()->user()->hasPermission('employee.view'), 403);

        $employees = Employee::orderBy('name')->get();

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

