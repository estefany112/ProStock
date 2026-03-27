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
        'fecha_ingreso',
        'fecha_baja',
        'active',
        'isr',
    ];

    public function planillas()
    {
        return $this->belongsToMany(Planilla::class, 'planilla_detalles')
                    ->withPivot('salary_base_quincenal', 'bonificacion', 'igss', 'isr', 'otros_descuentos', 'liquido_recibir')
                    ->withTimestamps();
    }

    public function scopeActivosEnRango($query, $inicio, $fin)
    {
        return $query->where('fecha_ingreso', '<=', $fin)
            ->where(function($q) use ($inicio) {
                $q->whereNull('fecha_baja')
                ->orWhere('fecha_baja', '>=', $inicio);
            });
    }

    public function salaryHistories()
    {
        return $this->hasMany(SalaryHistory::class);
    }

}
