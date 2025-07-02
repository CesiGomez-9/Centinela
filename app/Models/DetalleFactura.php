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
        'precioCompra',
        'precioVenta',
        'cantidad',
        'iva',
        'total',
    ];

    public function factura()
    {
        return $this->belongsTo(Factura::class);
    }
}
