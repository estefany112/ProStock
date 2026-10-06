<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class VehicleChecklistItem extends Model
{
    protected $fillable = [
        'checklist_id',
        'catalog_id',
        'response',
        'observation',
    ];

    public function checklist(): BelongsTo
    {
        return $this->belongsTo(
            VehicleChecklist::class,
            'checklist_id'
        );
    }

    public function catalog(): BelongsTo
    {
        return $this->belongsTo(
            VehicleChecklistCatalog::class,
            'catalog_id'
        );
    }

    public function photos(): HasMany
    {
        return $this->hasMany(
            VehicleChecklistPhoto::class,
            'checklist_item_id'
        );
    }
}