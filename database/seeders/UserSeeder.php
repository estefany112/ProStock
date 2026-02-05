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
        User::firstOrCreate(
            ['email' => 'admin@proserve.com'],
            [
                'name' => 'Administrador Inventario',
                'password' => Hash::make('Admin123!'),
            ]
        );

        User::firstOrCreate(
            ['email' => 'asistente@proserve.com'],
            [
                'name' => 'Asistente Inventario',
                'password' => Hash::make('Asistente123!'),
            ]
        );
    }
}
