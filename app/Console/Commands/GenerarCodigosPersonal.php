<?php

namespace App\Console\Commands;

use App\Models\Employee;
use Illuminate\Console\Command;

class GenerarCodigosPersonal extends Command
{
    protected $signature = 'empleados:generar-codigos';

    protected $description = 'Genera códigos personales para empleados que no tengan uno';

    public function handle(): int
    {
        $empleados = Employee::whereNull('codigo_personal')
            ->orWhere('codigo_personal', '')
            ->get();

        if ($empleados->isEmpty()) {
            $this->info('No hay empleados pendientes de código.');

            return self::SUCCESS;
        }

        $generados = 0;

        foreach ($empleados as $empleado) {

            $codigo = Employee::generarCodigoPersonal($empleado);

            $empleado->codigo_personal = $codigo;

            $empleado->save();

            $generados++;

            $this->info(
                "{$empleado->name} → {$codigo}"
            );
        }

        $this->newLine();

        $this->info(
            "Proceso terminado correctamente."
        );

        $this->info(
            "Códigos generados: {$generados}"
        );

        return self::SUCCESS;
    }
}
