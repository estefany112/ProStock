<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class VehicleTrip extends Model
{
    protected $fillable = [
        'external_id',
        'vehicle_id',
        'driver_id',
        'registered_by_employee_id',
        'departure_at',
        'departure_mileage',
        'departure_fuel',
        'destination',
        'project_id',
        'status',
        'return_at',
        'return_mileage',
        'return_fuel',
        'return_observations',
        'returned_by_employee_id',
    ];

    protected $casts = [
        'departure_at' => 'datetime',
        'return_at' => 'datetime',
        'departure_mileage' => 'integer',
        'return_mileage' => 'integer',
    ];

    /**
     * Vehículo utilizado en el viaje.
     */
    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehiculo::class, 'vehicle_id');
    }

    /**
     * Empleado que conduce el vehículo.
     */
    public function driver(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'driver_id');
    }

    /**
     * Empleado que registró la salida.
     */
    public function registeredByEmployee(): BelongsTo
    {
        return $this->belongsTo(
            Employee::class,
            'registered_by_employee_id'
        );
    }

    /**
     * Acompañantes registrados en el viaje.
     */
    public function passengers(): HasMany
    {
        return $this->hasMany(
            VehicleTripPassenger::class,
            'trip_id'
        );
    }

    public function returnedByEmployee(): BelongsTo
    {
        return $this->belongsTo(
            Employee::class,
            'returned_by_employee_id'
        );
    }

    public function checklist(): HasOne
    {
        return $this->hasOne(
            VehicleChecklist::class,
            'trip_id'
        );
    }
}