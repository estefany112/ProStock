<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $fillable = [
        'codigo',
        'descripcion',
        'precio_unitario',
        'stock_actual',
        'categoria_id',
        'unidad_medida',
        'marca',
        'fila_id',
        'columna_id',
        'nivel_id',
        'ubicacion',      
    ];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function entradas()
    {
        return $this->hasMany(Entrada::class);
    }

    public function salidas()
    {
        return $this->hasMany(Salida::class);
    }

    public function fila() { 
        return $this->belongsTo(Fila::class); 
    }

    public function columna() { 
        return $this->belongsTo(Columna::class); 
    }

    public function nivel() { 
        return $this->belongsTo(Nivel::class); 
    }

    public function getTienePrecioAttribute(): bool
    {
        return $this->precio_unitario !== null;
    }

    public function getPrecioFormateadoAttribute(): ?string
    {
        return $this->precio_unitario !== null
            ? number_format($this->precio_unitario, 2)
            : null;
    }

}
