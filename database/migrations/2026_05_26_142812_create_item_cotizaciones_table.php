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
        Schema::create('item_cotizaciones', function (Blueprint $table) {
            $table->id();

            // Relación cotización
            $table->foreignId('cotizacion_id')
                  ->constrained('cotizaciones')
                  ->cascadeOnDelete();

            // Datos item
            $table->integer('cantidad');

            $table->string('unidad_medida');

            $table->text('descripcion');

            $table->decimal('precio_unitario', 15, 2);

            $table->decimal('total', 15, 2);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_cotizaciones');
    }
};
