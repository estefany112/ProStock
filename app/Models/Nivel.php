<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nivel extends Model
{
    protected $table = 'niveles';

    protected $fillable = ['numero'];

    public function productos()
    {
        return $this->hasMany(Producto::class);
    }
}
