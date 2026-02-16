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
        Schema::create('solicitudes', function (Blueprint $table) {
            $table->id();

            // Relación con employees (tu tabla real)
            $table->foreignId('empleado_id')
                ->constrained('employees')
                ->onDelete('cascade');

            // Estado del flujo
            $table->enum('estado', [
                'pendiente',
                'aprobado',
                'rechazado',
                'entregado',
                'devuelto'
            ])->default('pendiente');

            // Observación del empleado
            $table->text('observacion')->nullable();

            // Comentario del administrador
            $table->text('comentario_admin')->nullable();

            // Usuario que aprobó
            $table->foreignId('aprobado_por')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamp('fecha_aprobacion')->nullable();

            // Usuario que entregó (bodega)
            $table->foreignId('entregado_por')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamp('fecha_entrega')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('solicitudes');
    }
};
