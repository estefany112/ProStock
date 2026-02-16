<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SolicitudDetalle extends Model
{
    use HasFactory;
    protected $table = 'solicitud_detalles';

    protected $fillable = [
        'solicitud_id',
        'descripcion',
        'cantidad',
    ];

    // Relación con solicitud
    public function solicitud()
    {
        return $this->belongsTo(Solicitud::class);
    }
}