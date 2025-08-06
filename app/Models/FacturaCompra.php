<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FacturaCompra extends Model
{
    use HasFactory;

    protected $table = 'facturas_compras';

    protected $fillable = [
        'numero_factura',
        'fecha',
        'proveedor_id',
        'forma_pago',
        'responsable_id',
        'subtotal',
        'impuestos',
        'totalF',
        'importe_gravado',
        'importe_exento',
        'importe_exonerado',
        'isv_15',
        'isv_18',
    ];

    /**
     * Relación uno a muchos con DetalleFacturaCompra.
     * Una factura puede tener muchos detalles de factura (productos).
     */
    public function detalles()
    {
        return $this->hasMany(DetalleFacturaCompra::class, 'factura_id');
    }

    /**
     * Relación muchos a uno con Proveedor.
     * Una factura pertenece a un proveedor.
     */
    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'proveedor_id');
    }

    /**
     * Relación muchos a uno con Empleado.
     * Una factura tiene un empleado responsable.
     */
    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'responsable_id');
    }
}
