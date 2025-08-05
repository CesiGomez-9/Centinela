<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instalacion extends Model
{
    use HasFactory;
    protected $table = 'instalaciones';

    protected $fillable = [
        'cliente_id',
        'tecnico_id',
        'servicio_id',
        'descripcion',
        'fecha_instalacion',
        'estado',
        'direccion'
    ];

    // Relaciones
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'empleado_id');
    }

    public function servicio()
    {
        return $this->belongsTo(Servicio::class);
    }
}
