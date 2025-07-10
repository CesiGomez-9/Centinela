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
        'proveedor_id',
        'forma_pago',
        'responsable_id',
        'subtotal',
        'impuestos',
        'totalF',
        // Nuevos campos para el desglose de la factura
        'importe_gravado',
        'importe_exento',
        'importe_exonerado',
        'isv_15',
        'isv_18',
    ];

    /**
     * Relación uno a muchos con DetalleFactura.
     * Una factura puede tener muchos detalles de factura (productos).
     */
    public function detalles()
    {
        return $this->hasMany(DetalleFactura::class);
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
