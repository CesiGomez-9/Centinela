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

    public function reportadoPorEmpleado()
    {
        return $this->belongsTo(Empleado::class, 'reportado_por');
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }
}
