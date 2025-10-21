<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Incidencia extends Model
{
    //

    protected $fillable = [
        'fecha',
        'tipo',
        'descripcion',
        'ubicacion',
        'agente_id',
        'reportado_por',
        'cliente_id',
        'estado'
    ];

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
