<?php

namespace Database\Seeders;

use App\Models\VehicleChecklistCatalog;
use Illuminate\Database\Seeder;

class VehicleChecklistCatalogSeeder extends Seeder
{
    public function run(): void
    {
        $items = [

            /*
            |--------------------------------------------------------------------------
            | COMBUSTIBLE Y FLUIDOS
            |--------------------------------------------------------------------------
            */
            [
                'category' => 'Combustible y fluidos',
                'name' => 'Chequeo de fluidos',
                'description' => 'Chequear presencia de fugas de aceite de motor, aceite de caja, combustible y refrigerante.',
                'response_type' => 'STATUS',
                'photo_requirement' => 'ON_ISSUE',
                'is_critical' => true,
                'sort_order' => 1,
            ],
            [
                'category' => 'Combustible y fluidos',
                'name' => 'Nivel de aceite de motor',
                'description' => 'Revisar el nivel de aceite del motor.',
                'response_type' => 'STATUS',
                'photo_requirement' => 'REQUIRED',
                'is_critical' => true,
                'sort_order' => 2,
            ],
            [
                'category' => 'Combustible y fluidos',
                'name' => 'Nivel de líquido de freno',
                'description' => 'Revisar el nivel del líquido de freno.',
                'response_type' => 'STATUS',
                'photo_requirement' => 'ON_ISSUE',
                'is_critical' => true,
                'sort_order' => 3,
            ],
            [
                'category' => 'Combustible y fluidos',
                'name' => 'Nivel de agua/refrigerante',
                'description' => 'Revisar el nivel de agua o refrigerante.',
                'response_type' => 'STATUS',
                'photo_requirement' => 'REQUIRED',
                'is_critical' => true,
                'sort_order' => 4,
            ],
            [
                'category' => 'Combustible y fluidos',
                'name' => 'Líquido de limpiabrisas',
                'description' => 'Revisar el nivel del líquido de limpiabrisas.',
                'response_type' => 'STATUS',
                'photo_requirement' => 'ON_ISSUE',
                'is_critical' => false,
                'sort_order' => 5,
            ],

            /*
            |--------------------------------------------------------------------------
            | CABINA Y SEGURIDAD
            |--------------------------------------------------------------------------
            */
            [
                'category' => 'Cabina y seguridad',
                'name' => 'Freno de pedal',
                'description' => 'Probar el freno de pedal con arranque suave.',
                'response_type' => 'STATUS',
                'photo_requirement' => 'ON_ISSUE',
                'is_critical' => true,
                'sort_order' => 6,
            ],
            [
                'category' => 'Cabina y seguridad',
                'name' => 'Espejos',
                'description' => 'Revisar limpieza y ajuste de los espejos.',
                'response_type' => 'STATUS',
                'photo_requirement' => 'ON_ISSUE',
                'is_critical' => false,
                'sort_order' => 7,
            ],
            
            /*
            |--------------------------------------------------------------------------
            | LUCES Y TABLERO
            |--------------------------------------------------------------------------
            */

            [
                'category' => 'Luces y tablero',
                'name' => 'Luces del vehículo',
                'description' => 'Verificar funcionamiento de luces frontales, traseras, de frenos y de placa.',
                'response_type' => 'STATUS',
                'photo_requirement' => 'ON_ISSUE',
                'is_critical' => true,
                'sort_order' => 8,
            ],
            [
                'category' => 'Luces y tablero',
                'name' => 'Indicadores del tablero',
                'description' => 'Revisar indicadores de aceite, voltaje, temperatura y registrar evidencia visual del tablero y kilometraje.',
                'response_type' => 'STATUS',
                'photo_requirement' => 'REQUIRED',
                'is_critical' => true,
                'sort_order' => 9,
            ],
            [
                'category' => 'Luces y tablero',
                'name' => 'Bocina',
                'description' => 'Revisar el funcionamiento de la bocina.',
                'response_type' => 'STATUS',
                'photo_requirement' => 'ON_ISSUE',
                'is_critical' => false,
                'sort_order' => 10,
            ],

            /*
            |--------------------------------------------------------------------------
            | SISTEMAS Y COMPONENTES
            |--------------------------------------------------------------------------
            */

            [
                'category' => 'Sistemas y componentes',
                'name' => 'Sistema hidráulico',
                'description' => 'Revisar presencia de fugas en el sistema hidráulico.',
                'response_type' => 'STATUS',
                'photo_requirement' => 'ON_ISSUE',
                'is_critical' => true,
                'sort_order' => 11,
            ],
        
            [
                'category' => 'Sistemas y componentes',
                'name' => 'Neumáticos',
                'description' => 'Inspección visual de neumáticos, desgaste, presión de aire y revisión general alrededor del vehículo.',
                'response_type' => 'STATUS',
                'photo_requirement' => 'ON_ISSUE',
                'is_critical' => true,
                'sort_order' => 12,
            ],

            /*
            |--------------------------------------------------------------------------
            | EXTERIOR
            |--------------------------------------------------------------------------
            */

            [
                'category' => 'Exterior',
                'name' => 'Parabrisas',
                'description' => 'Limpiar y revisar parabrisas. Reportar fracturas, roturas o impactos.',
                'response_type' => 'STATUS',
                'photo_requirement' => 'ON_ISSUE',
                'is_critical' => true,
                'sort_order' => 13,
            ],
            [
                'category' => 'Exterior',
                'name' => 'Posición y limpieza de espejos',
                'description' => 'Ajustar los espejos en la posición correcta y verificar que estén limpios.',
                'response_type' => 'STATUS',
                'photo_requirement' => 'ON_ISSUE',
                'is_critical' => false,
                'sort_order' => 14,
            ],

            /*
            |--------------------------------------------------------------------------
            | MOTOR Y PRUEBA
            |--------------------------------------------------------------------------
            */

            [
                'category' => 'Motor y prueba',
                'name' => 'Prueba de frenos a baja velocidad',
                'description' => 'Cuando arranque el vehículo, aplicar los frenos a baja velocidad.',
                'response_type' => 'STATUS',
                'photo_requirement' => 'ON_ISSUE',
                'is_critical' => true,
                'sort_order' => 15,
            ],
            [
                'category' => 'Accesorios',
                'name' => 'Inversor de voltaje',
                'description' => 'Verificar funcionamiento y cuidado del inversor de voltaje.',
                'response_type' => 'STATUS',
                'photo_requirement' => 'OPTIONAL',
                'is_critical' => false,
                'sort_order' => 16,
            ],
        ];

        foreach ($items as $item) {
            VehicleChecklistCatalog::updateOrCreate(
                [
                    'name' => $item['name'],
                ],
                array_merge($item, [
                    'active' => true,
                ])
            );
        }

        // Desactivar elementos que ya no están incluidos en el catálogo
        $nombres = array_column($items, 'name');

        VehicleChecklistCatalog::whereNotIn('name', $nombres)
            ->update(['active' => false]);
    }
}