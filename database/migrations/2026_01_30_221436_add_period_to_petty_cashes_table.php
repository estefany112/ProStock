<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('petty_cashes', function (Blueprint $table) {
            $table->date('period_start')->nullable()->after('opened_by');
            $table->date('period_end')->nullable()->after('period_start');
        });

        // Actualizar registros existentes
        DB::table('petty_cashes')->update([
            'period_start' => Carbon::now()->startOfWeek(),
            'period_end'   => Carbon::now()->endOfWeek(),
        ]);
    }

    public function down(): void
    {
        Schema::table('petty_cashes', function (Blueprint $table) {
            $table->dropColumn(['period_start', 'period_end']);
        });
    }
};