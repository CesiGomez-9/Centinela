<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Turno extends Model
{
    use HasFactory;

    protected $table = 'turnos';

    protected $fillable = [
        'servicio_id',
        'cliente_id',
        'empleados_asignados',
        'fecha_inicio',
        'fecha_fin',
        'hora_inicio',
        'hora_fin',
        'tipo_turno',
        'observaciones',
    ];

    protected $casts = [
        'empleados_asignados' => 'array',
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
        'hora_inicio' => 'datetime',
        'hora_fin' => 'datetime',
    ];


    public function empleado()
    {
        return $this->belongsTo(Empleado::class);
    }


    public function servicio()
    {
        return $this->belongsTo(Servicio::class);
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }
}
