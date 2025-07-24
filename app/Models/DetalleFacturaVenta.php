<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleFacturaVenta extends Model
{
    use HasFactory;

    protected $table = 'detalles_facturas_ventas';

    protected $fillable = [
        'factura_venta_id', 'product_id', 'nombre', 'categoria',
        'precio_venta', 'cantidad', 'iva', 'subtotal', 'responsable_id'
    ];

    public function facturaVenta()
    {
        return $this->belongsTo(FacturaVenta::class, 'factura_venta_id');
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'product_id');
    }

    public function responsable()
    {
        return $this->belongsTo(Empleado::class, 'responsable_id');
    }


}

