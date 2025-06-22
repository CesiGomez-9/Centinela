<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Empleado extends Model
{

    public $timestamps = false;

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
        'alergias',
        'alergiaOtros',
        'alergiaAlimentos',
        'alergiaMedicamentos'
    ];
    protected $casts = [
        'alergias' => 'array',
    ];
}
