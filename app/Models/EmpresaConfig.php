<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmpresaConfig extends Model
{
    protected $table = 'empresa_configs';

    protected $fillable = [
        'nombre',
        'nit',
        'regimen_isr',
        'direccion',
        'telefono',
        'correo',
        'cuenta_bancaria',
    ];
}
