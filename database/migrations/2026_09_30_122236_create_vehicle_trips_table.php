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
        Schema::create('vehicle_trips', function (Blueprint $table) {
            $table->id();

            // ID proveniente del sistema externo.
            // Nos servirá posteriormente para evitar registros duplicados.
            $table->string('external_id', 100)
                ->nullable()
                ->unique();

            // Vehículo utilizado.
            $table->foreignId('vehicle_id')
                ->constrained('vehiculos')
                ->restrictOnDelete();

            // Empleado que conduce el vehículo.
            $table->foreignId('driver_id')
                ->constrained('employees')
                ->restrictOnDelete();

            // Empleado que registró la información.
            // Puede ser diferente al conductor.
            $table->foreignId('registered_by_employee_id')
                ->nullable()
                ->constrained('employees')
                ->restrictOnDelete();

            // =====================================================
            // SALIDA
            // =====================================================

            $table->dateTime('departure_at');

            $table->unsignedInteger('departure_mileage');

            $table->string('departure_fuel', 10);

            $table->string('destination');

            // Por ahora no creamos llave foránea porque después
            // revisaremos la estructura real del módulo de proyectos.
            $table->unsignedBigInteger('project_id')
                ->nullable();

            // Estado actual del viaje.
            // PENDIENTE / EN_USO / RETORNADO
            $table->string('status', 30)
                ->default('PENDIENTE');

            // =====================================================
            // RETORNO
            // =====================================================

            $table->dateTime('return_at')
                ->nullable();

            $table->unsignedInteger('return_mileage')
                ->nullable();

            $table->string('return_fuel', 10)
                ->nullable();

            $table->text('return_observations')
                ->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicle_trips');
    }
};