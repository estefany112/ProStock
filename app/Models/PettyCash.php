<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class PettyCash extends Model
{
    protected $table = 'petty_cashes';
    protected $casts = [
        'period_start' => 'date',
        'period_end'   => 'date',
        'closed_at'    => 'datetime',
    ];

    protected $fillable = [
        'initial_balance',
        'current_balance',
        'opened_by',
        'status',
        'period_start',
        'period_end',
        'closed_at',
    ];

    public function movements()
    {
        return $this->hasMany(PettyCashMovement::class);
    }

    public function opener()
    {
        return $this->belongsTo(User::class, 'opened_by');
    }

    protected static function booted()
    {
        static::creating(function ($cash) {
            if (!$cash->period_start || !$cash->period_end) {
                $cash->period_start = now()->startOfWeek();
                $cash->period_end   = now()->endOfWeek();
            }
        });
    }

    public function recalculateBalance()
    {
        $movementsBalance = $this->movements()
            ->whereNull('parent_id')
            ->sum(\DB::raw("
                CASE
                    WHEN movement_category = 'income' THEN amount
                    WHEN movement_category = 'expense' THEN -amount
                    WHEN movement_category = 'advance' AND status = 'approved' THEN -amount
                    ELSE 0
                END
            "));

        $this->update([
            'current_balance' => $this->initial_balance + $movementsBalance
        ]);
    }

}
