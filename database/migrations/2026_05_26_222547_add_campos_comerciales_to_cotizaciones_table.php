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
            $table->string('lugar_entrega')->nullable();
            $table->string('tiempo_entrega')->nullable();
            $table->string('garantia')->nullable();
            $table->string('forma_pago')->nullable();
            $table->string('validez_oferta')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cotizaciones', function (Blueprint $table) {
            $table->dropColumn(['lugar_entrega', 'tiempo_entrega', 'garantia', 'forma_pago', 'validez_oferta']);
        });
    }
};
