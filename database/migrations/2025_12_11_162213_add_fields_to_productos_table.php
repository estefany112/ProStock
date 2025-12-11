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
        Schema::table('productos', function (Blueprint $table) {

            //Columna de Ubicación como texto
            $table->string('ubicacion')->nullable()->after('stock_actual');

            //Columna de Unidad de medida como texto
             $table->string('unidad_medida')->nullable()->after('ubicacion');

             //Columna de Marca como texto
             $table->string('marca')->nullable()->after('unidad_medida');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('productos', function (Blueprint $table) {
            $table->dropColumn(['ubicacion', 'unidad_medida', 'marca']);
        });
    }
};
