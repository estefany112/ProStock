<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entrada extends Model
{
    use HasFactory;

    // Campos que son permitidos para asignación masiva
    protected $fillable = [
        'producto_id',
        'cantidad',
        'motivo',
        'fecha_entrada', 
    ];

    protected $dates = ['fecha_entrada'];

    // Relación con Producto (un producto puede tener muchas entradas)
    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}
