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
        'proveedor_id', // Ahora usamos el ID del proveedor
        'forma_pago',
        'responsable_id', // Ahora usamos el ID del empleado responsable
        'subtotal',
        'impuestos',
        'totalF',
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
        return $this->belongsTo(Proveedor::class);
    }

    /**
     * Relación muchos a uno con Empleado.
     * Una factura tiene un empleado responsable.
     */
    public function empleado()
    {
        // Si renombraste responsable_id a empleado_id en la migración,
        // esto debería ser $this->belongsTo(Empleado::class, 'empleado_id');
        // Pero si mantuviste responsable_id, es $this->belongsTo(Empleado::class, 'responsable_id');
        return $this->belongsTo(Empleado::class, 'responsable_id');
    }

    /*
     * La relación 'producto()' se elimina porque los productos de una factura
     * se gestionan a través de la tabla 'detalles' (DetalleFactura).
     * La columna 'producto_id' en la tabla 'facturas' se ha eliminado en una migración.
     */
     public function producto()
    {
         return $this->belongsTo(Producto::class);
     }
}
