<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    use HasFactory;
    protected $fillable = [
        'nombre_servicio',
        'descripcion',
        'direccion',
        'ciudad',
        'fecha_inicio',
        'duracion',
        'horario',
        'cantidad_personal',
        'tipo_personal',
        'incluye_equipamiento',
        'fecha_solicitud',
    ];
    protected $casts = [
        'fecha_inicio' => 'datetime',
        'fecha_solicitud' => 'datetime',
    ];
}
