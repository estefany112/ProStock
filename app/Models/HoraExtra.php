<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HoraExtra extends Model
{
    protected $table = 'horas_extras';
    
    protected $fillable = [
        'empleado_id',
        'fecha',
        'horas',
        'salario_base',
        'total'
    ];

    public function empleado()
    {
        return $this->belongsTo(Employee::class, 'empleado_id');
    }
}
