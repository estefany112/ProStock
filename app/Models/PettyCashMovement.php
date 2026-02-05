<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PettyCashMovement extends Model
{
    protected $fillable = [
        'petty_cash_id',
        'type',
        'movement_category',
        'amount',
        'concept',
        'voucher',
        'responsible',
        'user_id',
        'parent_id',
    ];

    public function pettyCash()
    {
        return $this->belongsTo(PettyCash::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}