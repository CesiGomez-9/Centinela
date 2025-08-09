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
        'servicio_id',
        'descripcion',
        'direccion',
        'fecha_instalacion',
        'costo_instalacion',
        'factura_id'
    ];

    // Relaciones
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function empleado()
    {
        return $this->belongsToMany(Empleado::class, 'empleado_id');
    }

    public function servicio()
    {
        return $this->belongsTo(Servicio::class);
    }


    public function factura()
    {
        return $this->belongsTo(FacturaVenta::class, 'factura_id');
    }
    public function tecnicos()
    {
        return $this->belongsToMany(Empleado::class);
    }



}
