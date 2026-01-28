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
        Permission::insert([
            // Productos
            ['name'=>'view_products','label'=>'Ver productos','created_at'=>now(),'updated_at'=>now()],
            ['name'=>'create_products','label'=>'Crear productos','created_at'=>now(),'updated_at'=>now()],
            ['name'=>'edit_products','label'=>'Editar productos','created_at'=>now(),'updated_at'=>now()],
            ['name'=>'delete_products','label'=>'Eliminar productos','created_at'=>now(),'updated_at'=>now()],

            // Entradas
            ['name'=>'view_entries','label'=>'Ver entradas','created_at'=>now(),'updated_at'=>now()],
            ['name'=>'create_entries','label'=>'Crear entradas','created_at'=>now(),'updated_at'=>now()],
            ['name'=>'approve_entries','label'=>'Aprobar entradas','created_at'=>now(),'updated_at'=>now()],

            // Salidas
            ['name'=>'view_exits','label'=>'Ver salidas','created_at'=>now(),'updated_at'=>now()],
            ['name'=>'create_exits','label'=>'Crear salidas','created_at'=>now(),'updated_at'=>now()],
            ['name'=>'approve_exits','label'=>'Aprobar salidas','created_at'=>now(),'updated_at'=>now()],

            // Usuarios / roles
            ['name'=>'view_users','label'=>'Ver usuarios','created_at'=>now(),'updated_at'=>now()],
            ['name'=>'assign_roles','label'=>'Asignar roles','created_at'=>now(),'updated_at'=>now()],

            // Reportes
            ['name'=>'view_reports','label'=>'Ver reportes','created_at'=>now(),'updated_at'=>now()],
            ['name'=>'export_reports','label'=>'Exportar reportes','created_at'=>now(),'updated_at'=>now()],
        ]);
    }
}
