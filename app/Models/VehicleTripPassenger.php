<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VehicleTripPassenger extends Model
{
    protected $fillable = [
        'trip_id',
        'employee_id',
    ];

    /**
     * Viaje al que pertenece el acompañante.
     */
    public function trip(): BelongsTo
    {
        return $this->belongsTo(
            VehicleTrip::class,
            'trip_id'
        );
    }

    /**
     * Empleado que viaja como acompañante.
     */
    public function employee(): BelongsTo
    {
        return $this->belongsTo(
            Employee::class,
            'employee_id'
        );
    }
}