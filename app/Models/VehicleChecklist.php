<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class VehicleChecklist extends Model
{
    protected $fillable = [
        'trip_id',
        'result',
        'observations',
        'inspected_at',
    ];

    protected $casts = [
        'inspected_at' => 'datetime',
    ];

    public function trip(): BelongsTo
    {
        return $this->belongsTo(
            VehicleTrip::class,
            'trip_id'
        );
    }

    public function items(): HasMany
    {
        return $this->hasMany(
            VehicleChecklistItem::class,
            'checklist_id'
        );
    }
}