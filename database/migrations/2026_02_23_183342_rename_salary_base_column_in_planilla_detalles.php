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
        Schema::table('planilla_detalles', function (Blueprint $table) {
            $table->renameColumn('salary_base', 'salary_base_quincenal');
        });
    }

    public function down(): void
    {
        Schema::table('planilla_detalles', function (Blueprint $table) {
            $table->renameColumn('salary_base_quincenal', 'salary_base');
        });
    }
};