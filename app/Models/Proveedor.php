<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    use HasFactory;

    protected $table = 'proveedores';

    protected $fillable = [
        'nombreEmpresa',
        'direccion',
        'telefonodeempresa',
        'correoempresa',
        'nombrerepresentante',
        'telefonoderepresentante',
        'categoriarubro',
        'departamento',
    ];



}
