<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    protected $fillable = [
        'numero_factura',
        'fecha',
        'proveedor',
        'forma_pago',
        'subtotal',
        'impuestos',
        'totalF',
        'responsable',

    ];

    // Relación uno a muchos con DetalleFactura
    public function detalles()
    {
        return $this->hasMany(DetalleFactura::class);
    }
}
