<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('petty_cashes', function (Blueprint $table) {
            $table->dropColumn('cash_responsible');
        });
    }

    public function down()
    {
        Schema::table('petty_cashes', function (Blueprint $table) {
            $table->string('cash_responsible')->nullable();
        });
    }
};
