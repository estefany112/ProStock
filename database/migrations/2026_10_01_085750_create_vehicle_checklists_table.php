<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vehicle_checklists', function (Blueprint $table) {
            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Viaje / salida
            |--------------------------------------------------------------------------
            |
            | Cada checklist pertenece a una salida específica.
            |
            */
            $table->foreignId('trip_id')
                ->constrained('vehicle_trips')
                ->cascadeOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Resultado general
            |--------------------------------------------------------------------------
            |
            | APTO
            | APTO_CON_OBSERVACIONES
            | NO_APTO
            |
            */
            $table->string('result', 30);

            /*
            |--------------------------------------------------------------------------
            | Observaciones generales
            |--------------------------------------------------------------------------
            */
            $table->text('observations')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Fecha de realización
            |--------------------------------------------------------------------------
            */
            $table->dateTime('inspected_at');

            $table->timestamps();

            /*
            |--------------------------------------------------------------------------
            | Un checklist de salida por viaje
            |--------------------------------------------------------------------------
            */
            $table->unique(
                'trip_id',
                'vehicle_checklists_trip_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vehicle_checklists');
    }
};