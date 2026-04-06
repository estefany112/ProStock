<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class GenerarCorrelativosPlanillas extends Command
{
    protected $signature = 'planillas:correlativos';

    public function handle()
    {
        $registros = DB::table('planilla_detalles')
            ->join('planillas', 'planillas.id', '=', 'planilla_detalles.planilla_id')
            ->orderBy('planillas.created_at') // orden real
            ->orderBy('planilla_detalles.id') // orden interno
            ->select('planilla_detalles.id')
            ->get();

        $contador = 1;

        foreach ($registros as $registro) {
            DB::table('planilla_detalles')
                ->where('id', $registro->id)
                ->update([
                    'correlativo' => $contador++
                ]);
        }

        $this->info('Correlativos generados correctamente');
    }
}
