<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Administrador Inventario',
            'email' => 'admin@proserve.com',
            'password' => Hash::make('Admin123!'),
        ]);

        User::create([
            'name' => 'Asistente Inventario',
            'email' => 'asistente@proserve.com',
            'password' => Hash::make('Asistente123!'),
        ]);
    }
}
