<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::insert([
            ['name'=>'admin','label'=>'Administrador','created_at'=>now(),'updated_at'=>now()],
            ['name'=>'almacen','label'=>'Encargado de Inventario','created_at'=>now(),'updated_at'=>now()],
            ['name'=>'operativo','label'=>'Usuario Operativo','created_at'=>now(),'updated_at'=>now()],
            ['name'=>'supervisor','label'=>'Supervisor','created_at'=>now(),'updated_at'=>now()],
            ['name'=>'compras','label'=>'Compras','created_at'=>now(),'updated_at'=>now()],
            ['name'=>'auditor','label'=>'Auditor / Contabilidad','created_at'=>now(),'updated_at'=>now()],
        ]);
    }
}
