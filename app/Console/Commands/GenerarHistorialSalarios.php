<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Employee;
use App\Models\SalaryHistory;

class GenerarHistorialSalarios extends Command
{
    protected $signature = 'salarios:generar-historial';
    protected $description = 'Genera historial inicial de salarios para empleados existentes';

    public function handle()
    {
        $empleados = Employee::all();

        foreach ($empleados as $empleado) {

            // Verificar si ya tiene historial
            $existe = SalaryHistory::where('employee_id', $empleado->id)->exists();

            if (!$existe) {

                SalaryHistory::create([
                    'employee_id' => $empleado->id,
                    'salary' => $empleado->salary_base,
                    'fecha_inicio' => $empleado->fecha_ingreso ?? now(),
                    'fecha_fin' => null
                ]);

                $this->info("✔ Historial creado para empleado ID: {$empleado->id}");
            } else {
                $this->warn("⚠ Ya tiene historial ID: {$empleado->id}");
            }
        }

        $this->info('✅ Proceso finalizado');
    }
}