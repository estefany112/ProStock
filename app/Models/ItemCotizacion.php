<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemCotizacion extends Model
{
    protected $table = 'item_cotizaciones';

    protected $fillable = [
        'cotizacion_id',
        'cantidad',
        'unidad_medida',
        'descripcion',
        'precio_unitario',
        'total',
        'tipo'
    ];

        /*
    |--------------------------------------------------------------------------
    | RELACIONES
    |--------------------------------------------------------------------------
    */

    public function cotizacion()
    {
        return $this->belongsTo(Cotizacion::class);
    }

}
