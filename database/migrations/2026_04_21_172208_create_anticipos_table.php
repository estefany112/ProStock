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
       Schema::create('anticipos', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('employee_id');

            $table->date('fecha');

            $table->decimal('monto', 10, 2)->default(0);

            $table->text('descripcion')->nullable();

            $table->string('estado')->default('pendiente');
            // pendiente / aplicado

            $table->timestamps();

            $table->foreign('employee_id')
                ->references('id')
                ->on('employees')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('anticipos');
    }
};
