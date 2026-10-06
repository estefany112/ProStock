<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('vehicle_checklist_catalogs', function (Blueprint $table) {
            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Información del punto de inspección
            |--------------------------------------------------------------------------
            */

            // Categoría para agrupar visualmente los puntos del checklist.
            // Ejemplos: Fluidos, Seguridad, Cabina, Iluminación, Motor.
            $table->string('category', 100);

            // Nombre del punto que verá el empleado.
            // Ejemplo: "Nivel de aceite de motor".
            $table->string('name', 255);

            // Instrucción o explicación adicional.
            $table->text('description')->nullable();


            /*
            |--------------------------------------------------------------------------
            | Tipo de respuesta
            |--------------------------------------------------------------------------
            |
            | STATUS:
            |   OK / MAL_FUNCIONAMIENTO / FALLA
            |
            | FUEL:
            |   1/4 / 1/2 / 3/4 / LLENO
            |
            */
            $table->string('response_type', 30)
                ->default('STATUS');


            /*
            |--------------------------------------------------------------------------
            | Requerimiento de fotografía
            |--------------------------------------------------------------------------
            |
            | REQUIRED:
            |   La fotografía siempre será obligatoria.
            |
            | ON_ISSUE:
            |   Será obligatoria cuando se reporte
            |   MAL_FUNCIONAMIENTO o FALLA.
            |
            | OPTIONAL:
            |   Puede adjuntarse fotografía, pero no es obligatoria.
            |
            */
            $table->string('photo_requirement', 30)
                ->default('ON_ISSUE');


            /*
            |--------------------------------------------------------------------------
            | Punto crítico
            |--------------------------------------------------------------------------
            |
            | Permite identificar componentes cuya falla puede determinar
            | posteriormente que el vehículo NO APTO para salir.
            |
            */
            $table->boolean('is_critical')
                ->default(false);


            /*
            |--------------------------------------------------------------------------
            | Estado del punto
            |--------------------------------------------------------------------------
            |
            | Nos permitirá retirar un punto del formulario sin eliminarlo
            | de inspecciones históricas.
            |
            */
            $table->boolean('active')
                ->default(true);


            /*
            |--------------------------------------------------------------------------
            | Orden de presentación
            |--------------------------------------------------------------------------
            */
            $table->unsignedInteger('sort_order')
                ->default(0);


            $table->timestamps();


            /*
            |--------------------------------------------------------------------------
            | Índices
            |--------------------------------------------------------------------------
            */
            $table->index(
                ['active', 'sort_order'],
                'vehicle_checklist_catalog_active_order_idx'
            );

            $table->index(
                'category',
                'vehicle_checklist_catalog_category_idx'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicle_checklist_catalogs');
    }
};