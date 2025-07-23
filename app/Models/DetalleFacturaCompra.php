<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DetalleFacturaCompra extends Model
{
    protected $table = 'detalles';

    use HasFactory;

    protected $fillable = [
        'factura_id',
        'product_id',
        'precio_compra',
        'precio_venta',
        'cantidad',
    ];

    protected $casts = [
        'precio_compra' => 'float',
        'precio_venta' => 'float',
        'cantidad' => 'integer',
    ];


    public function factura()
    {
        return $this->belongsTo(FacturaCompra::class, 'factura_id');
    }


    public function productoInventario()
    {
        return $this->belongsTo(Producto::class, 'product_id');
    }

    public function facturaVenta()
    {
        return $this->belongsTo(FacturaVenta::class, 'factura_venta_id');
    }

}
