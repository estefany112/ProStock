<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $permissions = [
        // Productos
        ['name'=>'view_products','label'=>'Ver productos'],
        ['name'=>'create_products','label'=>'Crear productos'],
        ['name'=>'edit_products','label'=>'Editar productos'],
        ['name'=>'delete_products','label'=>'Eliminar productos'],

        // Entradas
        ['name'=>'view_entries','label'=>'Ver entradas'],
        ['name'=>'create_entries','label'=>'Crear entradas'],
        ['name'=>'approve_entries','label'=>'Aprobar entradas'],

        // Salidas
        ['name'=>'view_exits','label'=>'Ver salidas'],
        ['name'=>'create_exits','label'=>'Crear salidas'],
        ['name'=>'approve_exits','label'=>'Aprobar salidas'],

        // Usuarios
        ['name'=>'view_users','label'=>'Ver usuarios'],
        ['name'=>'assign_roles','label'=>'Asignar roles'],

        // Reportes
        ['name'=>'view_reports','label'=>'Ver reportes'],
        ['name'=>'export_reports','label'=>'Exportar reportes'],

        // CAJA CHICA
        ['name'=>'caja.view','label'=>'Ver caja chica'],
        ['name'=>'caja.open','label'=>'Abrir caja chica'],
        ['name'=>'caja.move','label'=>'Registrar movimientos'],
        ['name'=>'caja.close','label'=>'Cerrar caja chica'],
        ['name'=>'caja.history','label'=>'Ver histórico de caja chica'],

        // SOLICITUDES
        ['name'=>'solicitudes.view','label'=>'Ver solicitudes'],
        ['name'=>'solicitudes.create','label'=>'Crear solicitudes'],
        ['name'=>'solicitudes.approve','label'=>'Aprobar solicitudes'],
        ['name'=>'solicitudes.deliver','label'=>'Entregar solicitudes'],

    ];

    foreach ($permissions as $permission) {
        Permission::updateOrCreate(
            ['name' => $permission['name']],
            ['label' => $permission['label']]
        );
    }
    
    }
}
