<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}
