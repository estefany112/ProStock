<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VehicleChecklistPhoto extends Model
{
    protected $fillable = [
        'checklist_item_id',
        'path',
        'original_name',
        'mime_type',
        'size',
    ];

    protected $casts = [
        'size' => 'integer',
    ];

    public function checklistItem(): BelongsTo
    {
        return $this->belongsTo(
            VehicleChecklistItem::class,
            'checklist_item_id'
        );
    }
}