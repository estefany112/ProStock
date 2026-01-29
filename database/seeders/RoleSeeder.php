<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            ['name' => 'admin',     'label' => 'Administrador'],
            ['name' => 'asistente', 'label' => 'Asistente'],
            ['name' => 'almacen',   'label' => 'Encargado de Inventario'],
            ['name' => 'operativo', 'label' => 'Usuario Operativo'],
            ['name' => 'supervisor','label' => 'Supervisor'],
            ['name' => 'compras',   'label' => 'Compras'],
            ['name' => 'auditor',   'label' => 'Auditor / Contabilidad'],
        ];

        // obtener nombres
        $roleNames = collect($roles)->pluck('name')->toArray();

        // limpiar relaciones (pivotes)
        DB::table('role_user')
            ->whereIn(
                'role_id',
                Role::whereIn('name', $roleNames)->pluck('id')
            )
            ->delete();

        DB::table('permission_role')
            ->whereIn(
                'role_id',
                Role::whereIn('name', $roleNames)->pluck('id')
            )
            ->delete();

        // eliminar roles
        Role::whereIn('name', $roleNames)->delete();

        // recrear roles
        foreach ($roles as $role) {
            Role::create([
                'name'  => $role['name'],
                'label' => $role['label'],
            ]);
        }
    }
}
