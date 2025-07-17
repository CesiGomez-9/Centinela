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
        'costo',
        'duracion_estimada',
        'productos',
    ];

    protected $casts = [
        'productos' => 'array',
    ];
}

