<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('planilla_detalles', function (Blueprint $table) {

            $table->string('estado_pago')
                ->default('pendiente')
                ->after('liquido_recibir');

            $table->timestamp('fecha_pago')
                ->nullable()
                ->after('estado_pago');

            $table->foreignId('usuario_pago_id')
                ->nullable()
                ->after('fecha_pago')
                ->constrained('users')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('planilla_detalles', function (Blueprint $table) {
            $table->dropForeign(['usuario_pago_id']);
            $table->dropColumn([
                'estado_pago',
                'fecha_pago',
                'usuario_pago_id'
            ]);
        });
    }
};