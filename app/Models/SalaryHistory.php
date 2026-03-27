<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalaryHistory extends Model
{
    protected $fillable = [
    'employee_id',
    'salary',
    'fecha_inicio',
    'fecha_fin'
];
}
