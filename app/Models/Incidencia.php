<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Incidencia extends Model
{
    //

    public function agentes()
    {
        return $this->belongsToMany(Empleado::class);
    }
}
