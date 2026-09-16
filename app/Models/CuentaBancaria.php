<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CuentaBancaria extends Model
{
    protected $table = 'cuentas_bancarias';

    protected $fillable = [
        'empresa_config_id',
        'tipo_cliente',
        'datos_bancarios',
    ];

    public function empresaConfig()
    {
        return $this->belongsTo(EmpresaConfig::class, 'empresa_config_id');
    }
}