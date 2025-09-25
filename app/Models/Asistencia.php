<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Asistencia extends Model
{
    protected $fillable = [
        'nombre',
        'apellido',
        'identidad',
        'turno_id',
        'hora_entrada',
        'hora_salida',
    ];
    protected $casts = [
        'hora_entrada' => 'datetime',
        'hora_salida' => 'datetime',
    ];

    public function turno()
    {
        return $this->belongsTo(Turno::class);
    }


}
