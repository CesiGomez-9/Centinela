<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Empleado extends Model
{
    protected $fillable = [
        'nombre',
        'apellido',
        'identidad',
        'direccion',
        'email',
        'telefono',
        'contactodeemergencia',
        'telefonodeemergencia',
        'tipodesangre',
        'alergias'
    ];
}
