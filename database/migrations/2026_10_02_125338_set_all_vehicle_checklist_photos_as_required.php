<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('vehicle_checklist_catalogs')
            ->update([
                'photo_requirement' => 'REQUIRED',
            ]);
    }

    public function down(): void
    {
        // Configuración original: fotografías siempre obligatorias.
        DB::table('vehicle_checklist_catalogs')
            ->whereIn('id', [3, 5, 16])
            ->update([
                'photo_requirement' => 'REQUIRED',
            ]);

        // Configuración original: fotografía obligatoria únicamente si hay problema.
        DB::table('vehicle_checklist_catalogs')
            ->whereIn('id', [
                2, 4, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15,
                17, 18, 19, 20, 21, 22, 23, 24, 25
            ])
            ->update([
                'photo_requirement' => 'ON_ISSUE',
            ]);

        // Configuración original: fotografía opcional.
        DB::table('vehicle_checklist_catalogs')
            ->where('id', 26)
            ->update([
                'photo_requirement' => 'OPTIONAL',
            ]);
    }
};