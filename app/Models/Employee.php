<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = [
        'name',
        'dpi',
        'position',
        'salary_base',
        'active',
        'isr',
    ];

    public function planillas()
    {
        return $this->belongsToMany(Planilla::class, 'planilla_detalles')
                    ->withPivot('salary_base_quincenal', 'bonificacion', 'igss', 'isr', 'otros_descuentos', 'liquido_recibir')
                    ->withTimestamps();
    }

}
