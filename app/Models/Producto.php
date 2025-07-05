<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $fillable = [
        'serie',
        'codigo',
        'nombre',
        'marca',
        'modelo',
        'cantidad',    // Asegúrate de que esté aquí
        'es_exento',   // Asegúrate de que esté aquí
        'categoria',
        'descripcion',
    ];

    protected $casts = [
        'cantidad' => 'integer',
        'es_exento' => 'boolean', // Asegúrate de que esté aquí
    ];
}

