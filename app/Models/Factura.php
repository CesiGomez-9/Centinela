<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Factura extends Model
{
    use HasFactory;

    protected $fillable = [
        'numero_factura',
        'fecha',
        'proveedor',
        'forma_pago',
        'responsable_id',
        'subtotal',
        'impuestos',
        'proveedores_id',
        'productos_id',
        'totalF',
    ];

    // Relación uno a muchos con DetalleFactura
    public function detalles()
    {
        return $this->hasMany(DetalleFactura::class);
    }
    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class);
    }

    public function empleado()
    {
        return $this->belongsTo(Empleado::class);
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}
