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
    ];
}
