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

            // Fila
            if (!Schema::hasColumn('productos', 'fila_id')) {
                $table->foreignId('fila_id')
                    ->nullable()
                    ->constrained('filas')
                    ->nullOnDelete()
                    ->after('stock_actual');
            }

            // Columna
            if (!Schema::hasColumn('productos', 'columna_id')) {
                $table->foreignId('columna_id')
                    ->nullable()
                    ->constrained('columnas')
                    ->nullOnDelete()
                    ->after('fila_id');
            }

            // Nivel
            if (!Schema::hasColumn('productos', 'nivel_id')) {
                $table->foreignId('nivel_id')
                    ->nullable()
                    ->constrained('niveles')
                    ->nullOnDelete()
                    ->after('columna_id');
            }

            // Ubicación concatenada
            if (!Schema::hasColumn('productos', 'ubicacion')) {
                $table->string('ubicacion')
                    ->nullable()
                    ->after('nivel_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('productos', function (Blueprint $table) {

            // Drop FKs only if columns exist
            if (Schema::hasColumn('productos', 'fila_id')) {
                $table->dropForeign(['fila_id']);
            }

            if (Schema::hasColumn('productos', 'columna_id')) {
                $table->dropForeign(['columna_id']);
            }

            if (Schema::hasColumn('productos', 'nivel_id')) {
                $table->dropForeign(['nivel_id']);
            }

            // Drop columns only if exist
            if (Schema::hasColumn('productos', 'ubicacion')) {
                $table->dropColumn('ubicacion');
            }

            if (Schema::hasColumn('productos', 'fila_id')) {
                $table->dropColumn('fila_id');
            }

            if (Schema::hasColumn('productos', 'columna_id')) {
                $table->dropColumn('columna_id');
            }

            if (Schema::hasColumn('productos', 'nivel_id')) {
                $table->dropColumn('nivel_id');
            }
        });
    }
};
