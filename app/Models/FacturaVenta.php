<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FacturaVenta extends Model
{
    use HasFactory;

    protected $table = 'facturas_ventas';

    protected $fillable = [
        'numero', 'cliente_id', 'fecha', 'subtotal', 'impuestos', 'total', 'forma_pago',
        'responsable_id',
    ];

    public function detalles()
    {
        return $this->hasMany(DetalleFacturaVenta::class, 'facturas_ventas_id');
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function responsable()
    {
        return $this->belongsTo(Empleado::class, 'responsable_id');
    }

    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'empleado_id');
    }


}

