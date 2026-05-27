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
        Schema::create('cotizaciones', function (Blueprint $table) {
            $table->id();
            // Folio automático
            $table->string('folio')->unique();

            // Fecha
            $table->date('fecha_emision');

            // Relación con cliente
            $table->foreignId('cliente_id')
                  ->constrained('clientes')
                  ->cascadeOnUpdate()
                  ->restrictOnDelete();
            
            // Totales
            $table->decimal('subtotal', 15, 2)->default(0);
            $table->decimal('iva', 15, 2)->default(0);
            $table->decimal('total', 15, 2)->default(0);

            // Estado
            $table->enum('estado', [
                'pendiente',
                'aceptada',
                'rechazada',
                'procesada'
            ])->default('pendiente');

            // Usuario creador
            $table->foreignId('creada_por')
                  ->constrained('users')
                  ->cascadeOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cotizaciones');
    }
};
