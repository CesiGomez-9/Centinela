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
        'costo_diurno',
        'costo_nocturno',
        'costo_24_horas',
        'productos',
    ];

    protected $casts = [
        'productos' => 'array',
        'costo_diurno' => 'float',
        'costo_nocturno' => 'float',
        'costo_24_horas' => 'float',
    ];

}
