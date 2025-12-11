<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Columna extends Model
{
    protected $fillable = ['numero'];

    public function productos()
    {
        return $this->hasMany(Producto::class);
    }
}
