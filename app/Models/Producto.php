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
        'precio_venta',
        'categoria_id',
        'fila_id',
        'columna_id',
        'nivel_id',
        'stock_actual',
        'ubicacion',        
        'unidad_medida',    
        'marca',      
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

}
