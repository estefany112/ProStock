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
        Schema::table('cotizaciones', function (Blueprint $table) {
            $table->text('clausula_despedida')->nullable()->after('validez_oferta');
            $table->string('nombre_firmante')->nullable()->after('clausula_despedida');
            $table->string('total_letras')->nullable()->after('nombre_firmante');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cotizaciones', function (Blueprint $table) {
            $table->dropColumn(['clausula_despedida', 'nombre_firmante', 'total_letras']);
        });
    }
};
