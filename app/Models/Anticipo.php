<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Anticipo extends Model
{
    protected $table = 'anticipos';

    protected $fillable = [
        'employee_id',
        'fecha',
        'monto',
        'descripcion',
        'estado'
    ];

    public function empleado()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
}