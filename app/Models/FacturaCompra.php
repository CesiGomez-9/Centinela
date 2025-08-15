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


    public function detalles()
    {
        return $this->hasMany(DetalleFacturaCompra::class, 'factura_id');
    }


    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'proveedor_id');
    }

    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'responsable_id');
    }
}
