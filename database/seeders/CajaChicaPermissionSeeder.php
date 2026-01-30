<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class CajaChicaPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'caja.view'   => 'Ver Caja Chica',
            'caja.open'   => 'Abrir Caja Chica',
            'caja.move'   => 'Registrar Movimientos Caja Chica',
            'caja.close'  => 'Cerrar Caja Chica',
            'caja.report' => 'Reportes Caja Chica',
        ];

        foreach ($permissions as $name => $label) {
           Permission::firstOrCreate(
                ['name' => $name],
                ['label' => $label]
            );
        }

        // Roles
        $auditor = Role::where('name', 'auditor')->first();
        $admin   = Role::where('name', 'admin')->first();

        // Asignación Auditor / Contabilidad
        $auditor->permissions()->syncWithoutDetaching(
            Permission::whereIn('name', [
                'caja.view',
                'caja.open',
                'caja.move',
                'caja.report',
            ])->pluck('id')
        );

        // Admin tiene todo
        $admin->permissions()->syncWithoutDetaching(
            Permission::whereIn('name', array_keys($permissions))->pluck('id')
        );
    }
}
