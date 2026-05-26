<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Cliente extends Model
{
    use HasFactory;

    protected $table = 'clientes';

    protected $fillable = [
        'tipo_cliente',
        'nombre',
        'empresa',
        'nit',
        'telefono',
        'correo',
        'direccion',
    ];

     public function cotizaciones(): HasMany
    {
        return $this->hasMany(Cotizacion::class);
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    public function getNombreCompletoAttribute(): string
    {
        return $this->empresa
            ? $this->empresa . ' - ' . $this->nombre
            : $this->nombre;
    }
}

