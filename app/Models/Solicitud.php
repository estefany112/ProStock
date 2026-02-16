<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Solicitud extends Model
{
    use HasFactory;

    protected $table = 'solicitudes';
    protected $fillable = [
        'empleado_id',
        'estado',
        'observacion',
        'comentario_admin',
        'aprobado_por',
        'fecha_aprobacion',
        'entregado_por',
        'fecha_entrega',
    ];

    // Relación con empleado
    public function empleado()
    {
        return $this->belongsTo(Employee::class, 'empleado_id');
    }

    // Relación con detalles
    public function detalles()
    {
        return $this->hasMany(SolicitudDetalle::class);
    }

    // Usuario que aprobó
    public function aprobador()
    {
        return $this->belongsTo(User::class, 'aprobado_por');
    }

    // Usuario que entregó
    public function entregador()
    {
        return $this->belongsTo(User::class, 'entregado_por');
    }
}