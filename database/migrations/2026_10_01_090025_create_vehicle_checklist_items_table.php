<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vehicle_checklist_items', function (Blueprint $table) {
            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Checklist al que pertenece
            |--------------------------------------------------------------------------
            */
            $table->foreignId('checklist_id')
                ->constrained('vehicle_checklists')
                ->cascadeOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Punto del catálogo evaluado
            |--------------------------------------------------------------------------
            */
            $table->foreignId('catalog_id')
                ->constrained('vehicle_checklist_catalogs')
                ->restrictOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Respuesta
            |--------------------------------------------------------------------------
            |
            | Para STATUS:
            | OK
            | MAL_FUNCIONAMIENTO
            | FALLA
            |
            | Para FUEL:
            | 1/4
            | 1/2
            | 3/4
            | LLENO
            |
            */
            $table->string('response', 30);

            /*
            |--------------------------------------------------------------------------
            | Observación específica
            |--------------------------------------------------------------------------
            |
            | Ejemplo:
            | "Se observa fuga leve de aceite."
            |
            */
            $table->text('observation')
                ->nullable();

            $table->timestamps();

            /*
            |--------------------------------------------------------------------------
            | Un punto solo puede responderse una vez por checklist
            |--------------------------------------------------------------------------
            */
            $table->unique(
                ['checklist_id', 'catalog_id'],
                'vehicle_checklist_item_unique'
            );

            $table->index(
                'response',
                'vehicle_checklist_items_response_idx'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vehicle_checklist_items');
    }
};