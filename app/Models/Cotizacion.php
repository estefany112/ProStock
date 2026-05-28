<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cotizacion extends Model
{
    protected $table = 'cotizaciones';

    protected $fillable = [
        'folio',
        'fecha_emision',
        'cliente_id',
        'subtotal',
        'iva',
        'total',
        'tipo',
        'estado',
        'creada_por',
        'lugar_entrega',
        'tiempo_entrega',
        'garantia',
        'forma_pago',
        'validez_oferta',
        'clausula_despedida',
        'nombre_firmante',    
        'total_letras',
    ];



    /*
    |--------------------------------------------------------------------------
    | RELACIONES
    |--------------------------------------------------------------------------
    */

    // Cliente
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    // Items
    public function items()
    {
        return $this->hasMany(ItemCotizacion::class);
    }

    // Usuario creador
    public function creador()
    {
        return $this->belongsTo(User::class, 'creada_por');
    }

    // Verificar si la cotización está congelada
    public function estaCongelada()
    {
        return $this->estado === 'congelada';
    }

    /*
    |--------------------------------------------------------------------------
    | FUNCIONES
    |--------------------------------------------------------------------------
    */

    // Generar folio automático
    public static function generarFolio()
    {
        $ultimo = self::latest()->first();

        $numero = $ultimo ? $ultimo->id + 1 : 1;

        return 'COT-' . str_pad($numero, 5, '0', STR_PAD_LEFT);
    }
}
