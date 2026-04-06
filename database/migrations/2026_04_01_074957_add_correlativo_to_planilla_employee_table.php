<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('planilla_detalles', function (Blueprint $table) {
            $table->unsignedBigInteger('correlativo')->nullable()->after('employee_id');
        });
    }

    public function down()
    {
        Schema::table('planilla_detalles', function (Blueprint $table) {
            $table->dropColumn('correlativo');
        });
    }
};

