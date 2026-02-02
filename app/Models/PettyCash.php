<?php

namespace App\Models;

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
        'initial_amount',
        'current_balance',
        'opened_by',
        'is_open',
        'closed_at'
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
    
}