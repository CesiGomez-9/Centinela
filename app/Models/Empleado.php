<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Empleado extends Model
{
    use HasFactory;

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
