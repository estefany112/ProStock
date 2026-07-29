<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Categoria;

class CategoriaSeeder extends Seeder
{
    public function run(): void
    {
        $categorias = [

            'Herramientas',
            'Material Eléctrico',
            'Ferretería',
            'Pinturas',
            'Equipo Industrial',
            'Limpieza',
            'Oficina',
            'Repuestos'

        ];


        foreach ($categorias as $categoria) {

            Categoria::create([
                'nombre' => $categoria
            ]);

        }
    }
}