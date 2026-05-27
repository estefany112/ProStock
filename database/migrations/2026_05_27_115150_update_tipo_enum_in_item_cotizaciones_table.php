<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;


return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("
            ALTER TABLE item_cotizaciones
            MODIFY COLUMN tipo 
            ENUM('comercial','servicio','material')
            NOT NULL DEFAULT 'comercial'
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("
            ALTER TABLE item_cotizaciones
            MODIFY COLUMN tipo 
            ENUM('servicio','material')
            NOT NULL DEFAULT 'servicio'
        ");
    }
};
