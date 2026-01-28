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
public function run()
{
    Role::insert([
        [
            'name' => 'admin',
            'label' => 'Administrador',
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'name' => 'almacen',
            'label' => 'Almacén',
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'name' => 'ventas',
            'label' => 'Ventas',
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'name' => 'supervisor',
            'label' => 'Supervisor',
            'created_at' => now(),
            'updated_at' => now(),
        ],
    ]);
}

}
