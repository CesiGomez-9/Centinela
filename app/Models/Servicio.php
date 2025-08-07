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
        'costo_diurno', // Nuevo campo para el costo diurno
        'costo_nocturno', // Nuevo campo para el costo nocturno
        'costo_24_horas', // Nuevo campo para el costo de 24 horas
        'productos',
    ];

    protected $casts = [
        'productos' => 'array',
    ];
}
