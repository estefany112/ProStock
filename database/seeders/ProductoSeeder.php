<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Producto;
use App\Models\Categoria;

class ProductoSeeder extends Seeder
{
    public function run(): void
    {

        $herramientas = Categoria::where('nombre','Herramientas')->first();
        $electrico = Categoria::where('nombre','Material Eléctrico')->first();
        $ferreteria = Categoria::where('nombre','Ferretería')->first();
        $pinturas = Categoria::where('nombre','Pinturas')->first();


        $productos = [

            [
                'codigo'=>'HER-001',
                'descripcion'=>'Taladro eléctrico 1/2 pulgada',
                'precio_unitario'=>350.00,
                'precio_venta'=>425.00,
                'stock_actual'=>10,
                'ubicacion'=>'A-01',
                'unidad_medida'=>'Unidad',
                'marca'=>'Bosch',
                'categoria_id'=>$herramientas->id,
            ],


            [
                'codigo'=>'HER-002',
                'descripcion'=>'Martillo profesional',
                'precio_unitario'=>50.00,
                'precio_venta'=>75.00,
                'stock_actual'=>25,
                'ubicacion'=>'A-02',
                'unidad_medida'=>'Unidad',
                'marca'=>'Stanley',
                'categoria_id'=>$herramientas->id,
            ],


            [
                'codigo'=>'ELE-001',
                'descripcion'=>'Cable eléctrico calibre 12',
                'precio_unitario'=>null,
                'precio_venta'=>0,
                'stock_actual'=>100,
                'ubicacion'=>'B-01',
                'unidad_medida'=>'Metro',
                'marca'=>'Centelsa',
                'categoria_id'=>$electrico->id,
            ],


            [
                'codigo'=>'FER-001',
                'descripcion'=>'Tornillo galvanizado 3 pulgadas',
                'precio_unitario'=>5.50,
                'precio_venta'=>8.00,
                'stock_actual'=>500,
                'ubicacion'=>'C-01',
                'unidad_medida'=>'Unidad',
                'marca'=>'Importado',
                'categoria_id'=>$ferreteria->id,
            ],


            [
                'codigo'=>'PIN-001',
                'descripcion'=>'Pintura gris secado rápido',
                'precio_unitario'=>null,
                'precio_venta'=>0,
                'stock_actual'=>15,
                'ubicacion'=>'D-01',
                'unidad_medida'=>'Galón',
                'marca'=>'Protecto',
                'categoria_id'=>$pinturas->id,
            ],


            [
                'codigo'=>'ELE-002',
                'descripcion'=>'Interruptor eléctrico sencillo',
                'precio_unitario'=>12.00,
                'precio_venta'=>18.00,
                'stock_actual'=>50,
                'ubicacion'=>'B-02',
                'unidad_medida'=>'Unidad',
                'marca'=>'BTicino',
                'categoria_id'=>$electrico->id,
            ],

        ];


        foreach($productos as $producto){

            Producto::create($producto);

        }

    }
}