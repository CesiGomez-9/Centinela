<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Capacitacion extends Model
{
    //
    protected $table = 'capacitaciones';

    protected $fillable = [
        'nombre',
        'correo',
        'contacto',
        'telefono',
        'modalidad',
        'nivel',
        'duracion',
        'fecha_inicio',
        'fecha_fin',
        'descripcion',
        'direccion'
    ];
}
