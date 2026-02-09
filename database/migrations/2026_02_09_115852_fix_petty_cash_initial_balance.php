<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
      // Recalcular saldo inicial para cajas cerradas
        DB::statement("
            UPDATE petty_cashes pc
            LEFT JOIN (
                SELECT
                    petty_cash_id,
                    SUM(
                        CASE
                            WHEN movement_category = 'income' THEN amount
                            WHEN movement_category = 'expense' THEN -amount
                            WHEN movement_category = 'advance' THEN -amount
                        END
                    ) AS neto_movimientos
                FROM petty_cash_movements
                GROUP BY petty_cash_id
            ) m ON m.petty_cash_id = pc.id
            SET pc.initial_balance = pc.current_balance - IFNULL(m.neto_movimientos, 0)
            WHERE pc.status = 'closed'
              AND pc.initial_balance = 0
        ");
    }

    public function down(): void
    {
        // No reversible automáticamente
    }
};