<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $fillable = [
        'tipo_cliente',
        'nombre',
        'empresa',
        'nit',
        'telefono',
        'correo',
        'direccion',
    ];
}
