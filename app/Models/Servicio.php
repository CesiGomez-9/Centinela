<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    use HasFactory;


    protected $fillable = [
        'nombre', 'categoria', 'marca', 'modelo', 'descripcion',
        'codigo_interno', 'fecha_ingreso', 'proveedor',
        'precio_compra', 'precio_venta', 'unidades_stock'
    ];
}
