<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    use HasFactory;
    protected $fillable = [
        'numero_factura',
        'fecha',
        'proveedor',
        'forma_pago',
        'subtotal',
        'impuestos',
        'totalF',
        'responsable_id',

    ];

    // Relación uno a muchos con DetalleFactura
    public function detalles()
    {
        return $this->hasMany(DetalleFactura::class);
    }
    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'responsable_id');
    }

}
