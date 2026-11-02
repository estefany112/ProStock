<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\EmployeeLicense;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class EmployeeLicenseController extends Controller
{
    /**
     * Mostrar formulario para registrar o editar licencia.
     */
    public function edit(Employee $employee)
    {
        $license = $employee->licenses()
            ->orderByDesc('expires_at')
            ->first();

        return view('employees.license', compact(
            'employee',
            'license'
        ));
    }

    /**
     * Registrar licencia.
     */
    public function store(Request $request, Employee $employee)
    {
        $validated = $request->validate([
            'license_number' => [
                'required',
                'string',
                'max:50',
                'unique:employee_licenses,license_number',
            ],

            'license_type' => [
                'required',
                'string',
                'max:20',
            ],

            'expires_at' => [
                'required',
                'date',
            ],
        ]);

        $employee->licenses()->create($validated);

        return redirect()
            ->route('employees.license.edit', $employee)
            ->with('success', 'Licencia registrada correctamente.');
    }

    /**
     * Actualizar licencia.
     */
    public function update(
        Request $request,
        Employee $employee,
        EmployeeLicense $license
    ) {
        // Seguridad: comprobar que la licencia pertenece al empleado.
        if ($license->employee_id !== $employee->id) {
            abort(404);
        }

        $validated = $request->validate([
            'license_number' => [
                'required',
                'string',
                'max:50',
                Rule::unique('employee_licenses', 'license_number')
                    ->ignore($license->id),
            ],

            'license_type' => [
                'required',
                'string',
                'max:20',
            ],

            'expires_at' => [
                'required',
                'date',
            ],
        ]);

        $license->update($validated);

        return redirect()
            ->route('employees.license.edit', $employee)
            ->with('success', 'Licencia actualizada correctamente.');
    }
}