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
        Schema::create('solicitud_detalles', function (Blueprint $table) {
            $table->id();

            $table->foreignId('solicitud_id')
                ->constrained('solicitudes')
                ->onDelete('cascade');

            // Descripción manual del material
            $table->string('descripcion');

            $table->integer('cantidad');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('solicitud_detalles');
    }
};
