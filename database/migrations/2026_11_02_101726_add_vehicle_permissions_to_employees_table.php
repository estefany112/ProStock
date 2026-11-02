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
    Schema::table('employees', function (Blueprint $table) {
        $table->boolean('puede_registrar_vehiculo')->default(true);
        $table->boolean('puede_ser_acompanante')->default(true);
    });
}

public function down(): void
{
    Schema::table('employees', function (Blueprint $table) {
        $table->dropColumn([
            'puede_registrar_vehiculo',
            'puede_ser_acompanante',
        ]);
    });
}
};
