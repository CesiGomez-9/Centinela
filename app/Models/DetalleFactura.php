<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetalleFactura extends Model
{
    protected $table = 'detalle_factura';

    protected $fillable = [
        'factura_id',
        'producto',
        'categoria',
        'precioCompra',
        'precioVenta',
        'cantidad',
        'iva',
        'total',
    ];

    // Relación inversa
    public function factura()
    {
        return $this->belongsTo(Factura::class);
    }
}
