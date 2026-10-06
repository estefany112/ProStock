<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vehiculo extends Model
{
    protected $fillable = [
        'placa',
        'marca',
        'anio',
        'color',
        'numero_interno',
        'tipo',
    ];

    /**
     * Viajes realizados por este vehículo.
     */
    public function trips(): HasMany
    {
        return $this->hasMany(
            VehicleTrip::class,
            'vehicle_id'
        );
    }
}
