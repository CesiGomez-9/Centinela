<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DetalleFactura extends Model
{
    protected $table = 'detalles';

    use HasFactory;

    protected $fillable = [
        'factura_id',
        'producto',
        'categoria',
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

    public function factura()
    {
        return $this->belongsTo(Factura::class);
    }
}
