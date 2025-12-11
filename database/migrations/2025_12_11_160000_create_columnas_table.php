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
        if (!Schema::hasTable('columnas')) {   
            Schema::create('columnas', function (Blueprint $table) {
                $table->id();
                $table->string('numero', 10);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('columnas')) {
            Schema::dropIfExists('columnas');
        }
    }
};