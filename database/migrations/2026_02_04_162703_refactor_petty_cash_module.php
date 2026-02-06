<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {

    public function up(): void
    {
        Schema::table('petty_cash_movements', function (Blueprint $table) {

            if (!Schema::hasColumn('petty_cash_movements', 'movement_category')) {
                $table->enum('movement_category', ['income', 'expense', 'advance'])
                      ->default('expense');
            }

            if (!Schema::hasColumn('petty_cash_movements', 'status')) {
                $table->enum('status', ['pending', 'settled'])->nullable();
            }

            if (!Schema::hasColumn('petty_cash_movements', 'parent_id')) {
                $table->foreignId('parent_id')
                      ->nullable()
                      ->constrained('petty_cash_movements')
                      ->nullOnDelete();
            }

            if (!Schema::hasColumn('petty_cash_movements', 'settled_at')) {
                $table->timestamp('settled_at')->nullable();
            }
        });

        Schema::table('petty_cashes', function (Blueprint $table) {

            if (!Schema::hasColumn('petty_cashes', 'initial_balance')) {
                $table->decimal('initial_balance', 10, 2)->default(0);
            }

            if (!Schema::hasColumn('petty_cashes', 'current_balance')) {
                $table->decimal('current_balance', 10, 2)->default(0);
            }

            if (!Schema::hasColumn('petty_cashes', 'status')) {
                $table->enum('status', ['open', 'closed'])->default('open');
            }
        });

        /**
         * 🧠 ADAPTAR DATOS EXISTENTES
         */

        DB::table('petty_cash_movements')
            ->where('type', 'income')
            ->update(['movement_category' => 'income']);

        DB::table('petty_cash_movements')
            ->where('type', 'expense')
            ->update(['movement_category' => 'expense']);

        /**
         * 🔁 Recalcular saldo de todas las cajas
         */
        DB::statement("
            UPDATE petty_cashes pc
            SET current_balance = (
                SELECT IFNULL(SUM(
                    CASE
                        WHEN pcm.movement_category = 'income' THEN pcm.amount
                        WHEN pcm.movement_category = 'expense' THEN -pcm.amount
                        WHEN pcm.movement_category = 'advance' THEN -pcm.amount
                    END
                ), 0)
                FROM petty_cash_movements pcm
                WHERE pcm.petty_cash_id = pc.id
            )
        ");
    }

    public function down(): void
    {
        Schema::table('petty_cash_movements', function (Blueprint $table) {
            if (Schema::hasColumn('petty_cash_movements', 'parent_id')) {
                $table->dropForeign(['parent_id']);
            }

            $table->dropColumn([
                'movement_category',
                'status',
                'parent_id',
                'settled_at',
            ]);
        });

        Schema::table('petty_cashes', function (Blueprint $table) {
            $table->dropColumn([
                'initial_balance',
                'current_balance',
                'status',
            ]);
        });
    }
};
