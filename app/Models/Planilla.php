<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Planilla extends Model
{
    protected $fillable = [
        'fecha_inicio',
        'fecha_fin',
        'estado',
        'isr',
    ];

    public function employees()
{
    return $this->belongsToMany(Employee::class, 'planilla_detalles')
                ->withPivot('salary_base_quincenal', 'bonificacion', 'igss', 'isr', 'otros_descuentos', 'liquido_recibir')
                ->withTimestamps();
}
}
