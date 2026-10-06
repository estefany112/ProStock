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
        Schema::create('vehicle_trip_passengers', function (Blueprint $table) {
            $table->id();

            // Viaje al que pertenece el acompañante.
            $table->foreignId('trip_id')
                ->constrained('vehicle_trips')
                ->cascadeOnDelete();

            // Empleado que viaja como acompañante.
            $table->foreignId('employee_id')
                ->constrained('employees')
                ->restrictOnDelete();

            $table->timestamps();

            // Evita agregar al mismo empleado dos veces
            // como acompañante en el mismo viaje.
            $table->unique([
                'trip_id',
                'employee_id'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicle_trip_passengers');
    }
};