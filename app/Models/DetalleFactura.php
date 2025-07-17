<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DetalleFactura extends Model
{
    protected $table = 'detalles'; // Asegura que se use la tabla 'detalles'

    use HasFactory;

    protected $fillable = [
        'factura_id',
        'product_id',
        'producto',    // Nombre del producto como string (mantenido por compatibilidad)
        'categoria',   // Categoría del producto como string (mantenido por compatibilidad)
        'precio_compra',
        'precio_venta',
        'cantidad',
        'iva',
        'total',
    ];

    protected $casts = [
        'precio_compra' => 'float',
        'precio_venta' => 'float',
        'cantidad' => 'integer',
        'iva' => 'float',
        'total' => 'float',
    ];

    /**
     * Relación muchos a uno con Factura.
     * Un detalle de factura pertenece a una única factura.
     */
    public function factura()
    {
        return $this->belongsTo(Factura::class);
    }

    /**
     * Relación muchos a uno con Producto.
     * Un detalle de factura se refiere a un producto específico del inventario.
     * Se usa un nombre diferente para la relación para evitar conflicto con el campo 'producto' (string).
     */
    public function productoInventario()
    {
        return $this->belongsTo(Producto::class, 'product_id');
    }

    // Eliminamos la relación 'public function producto()' para evitar ambigüedad
    // ya que 'productoInventario()' ya maneja la relación con el modelo Producto.
}
