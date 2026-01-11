<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Salida extends Model
{
    use HasFactory;

    protected $fillable = [
        'producto_id',
        'cantidad',
        'motivo',
        'fecha_salida'
    ];

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}
