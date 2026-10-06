<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vehicle_checklist_photos', function (Blueprint $table) {
            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Punto del checklist
            |--------------------------------------------------------------------------
            |
            | La fotografía queda asociada directamente al punto evaluado.
            |
            | Ejemplo:
            | Nivel de aceite -> foto
            | Refrigerante    -> foto
            | Tablero         -> foto
            |
            */
            $table->foreignId('checklist_item_id')
                ->constrained('vehicle_checklist_items')
                ->cascadeOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Ruta del archivo
            |--------------------------------------------------------------------------
            |
            | Ejemplo:
            | vehicle-checklists/2026/10/abc123.jpg
            |
            */
            $table->string('path', 500);

            /*
            |--------------------------------------------------------------------------
            | Nombre original
            |--------------------------------------------------------------------------
            */
            $table->string('original_name', 255)
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Tipo de archivo
            |--------------------------------------------------------------------------
            |
            | Ejemplo:
            | image/jpeg
            | image/png
            | image/webp
            |
            */
            $table->string('mime_type', 100)
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Tamaño
            |--------------------------------------------------------------------------
            |
            | Se almacenará en bytes.
            |
            */
            $table->unsignedBigInteger('size')
                ->nullable();

            $table->timestamps();

            $table->index(
                'checklist_item_id',
                'vehicle_checklist_photos_item_idx'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vehicle_checklist_photos');
    }
};