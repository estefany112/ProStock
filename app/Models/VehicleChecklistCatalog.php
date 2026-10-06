<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class VehicleChecklistCatalog extends Model
{
    protected $fillable = [
        'category',
        'name',
        'description',
        'response_type',
        'photo_requirement',
        'is_critical',
        'active',
        'sort_order',
    ];

    protected $casts = [
        'is_critical' => 'boolean',
        'active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function checklistItems(): HasMany
    {
        return $this->hasMany(
            VehicleChecklistItem::class,
            'catalog_id'
        );
    }
}