<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entrada extends Model
{
    use HasFactory;

    // Campos permitidos para asignación masiva
    protected $fillable = [
        'producto_id',
        'cantidad',
        'motivo',
        'fecha_entrada', 
    ];

    /**
     * Ajuste para Laravel moderno:
     * En lugar de $dates, usamos $casts para manejar la fecha automáticamente.
     */
    protected $casts = [
        'fecha_entrada' => 'datetime',
        'cantidad' => 'integer',
    ];

    /**
     * Relación con Producto.
     * Un registro de entrada pertenece a un único producto.
     */
    public function producto()
    {
        // Añadimos withDefault para evitar errores si un producto fuera borrado por accidente
        return $this->belongsTo(Producto::class)->withDefault([
            'descripcion' => 'Producto eliminado',
            'codigo' => 'N/A'
        ]);
    }

    /**
     * Opcional: Boot method para asignar la fecha de entrada automáticamente
     * si no se envía en el formulario.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($entrada) {
            if (!$entrada->fecha_entrada) {
                $entrada->fecha_entrada = now();
            }
        });
    }
}