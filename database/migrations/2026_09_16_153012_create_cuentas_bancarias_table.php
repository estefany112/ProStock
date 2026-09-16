<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cuentas_bancarias', function (Blueprint $table) {

            $table->id();

            $table->foreignId('empresa_config_id')
                ->constrained('empresa_configs')
                ->cascadeOnDelete();

            $table->string('tipo_cliente');

            $table->text('datos_bancarios');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cuentas_bancarias');
    }
};