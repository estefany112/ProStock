<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Permission;

class EmployeePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            ['name' => 'employee.view',    'label' => 'Ver empleados'],
            ['name' => 'employee.create',  'label' => 'Crear empleados'],
            ['name' => 'employee.edit',    'label' => 'Editar empleados'],
            ['name' => 'employee.disable', 'label' => 'Desactivar empleados'],
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(
                ['name' => $permission['name']],
                ['label' => $permission['label']]
            );
        }
    }
}