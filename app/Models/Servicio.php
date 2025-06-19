<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    use HasFactory;
    protected $fillable = [
        'nombre',
        'descripcion',
        'categoria',
        'tipo_personal',
        'costo',
        'duracion_cantidad',
        'duracion_tipo',
        'productos_tecnico',
        'productos_vigilancia'
    ];

    protected $casts = [
        'productos_tecnico' => 'array',
        'productos_vigilancia' => 'array',
    ];
}
