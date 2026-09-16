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
        if (Schema::hasColumn('petty_cashes', 'initial_amount')) {
            Schema::table('petty_cashes', function (Blueprint $table) {
                $table->dropColumn('initial_amount');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (!Schema::hasColumn('petty_cashes', 'initial_amount')) {
            Schema::table('petty_cashes', function (Blueprint $table) {
                $table->decimal('initial_amount', 10, 2)->default(0);
            });
        }
    }
};
