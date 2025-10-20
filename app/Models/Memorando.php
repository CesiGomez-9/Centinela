<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Memorando extends Model
{
    use HasFactory;
    protected $fillable = [
        'destinatario_id',
        'autor_id',
        'titulo',
        'contenido',
        'fecha',
        'tipo',
        'sancion',
        'adjunto',
        'observaciones'
    ];

    public function autor()
    {
        return $this->belongsTo(Empleado::class, 'autor_id');
    }

    public function destinatario()
    {
        return $this->belongsTo(Empleado::class, 'destinatario_id');
    }
}
