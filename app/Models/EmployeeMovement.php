<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeMovement extends Model
{
    protected $fillable = [
        'employee_id',
        'type',
        'date',
        'reason',
        'created_by',
    ];


    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }


    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}