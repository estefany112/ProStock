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
    Schema::create('planilla_detalles', function (Blueprint $table) {
        $table->id();

        $table->foreignId('planilla_id')
              ->constrained('planillas')
              ->onDelete('cascade');

        $table->foreignId('employee_id')
              ->constrained('employees')
              ->onDelete('cascade');

        $table->decimal('salary_base', 10, 2);
        $table->decimal('bonificacion', 10, 2)->default(0);
        $table->decimal('igss', 10, 2)->default(0);
        $table->decimal('otros_descuentos', 10, 2)->default(0);
        $table->decimal('liquido_recibir', 10, 2);

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('planilla_detalles');
    }
};
