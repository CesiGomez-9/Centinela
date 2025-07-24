<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\DetalleFactura;  // <- aquí afuera, al inicio

class Producto extends Model
{
    use HasFactory;

    protected $fillable = [
        'serie',
        'codigo',
        'nombre',
        'marca',
        'modelo',
        'cantidad',
        'impuesto_id',
        'categoria',
        'descripcion',
    ];

    protected $casts = [
        'cantidad' => 'integer',
    ];

    public function impuesto()
    {
        return $this->belongsTo(Impuesto::class);
    }

    public function detallefactura()
    {
        return $this->hasMany(DetalleFactura::class, 'product_id');
    }

    public function detallesFacturas()
    {
        return $this->hasMany(DetalleFacturaVenta::class);
    }

    public function scopeBuscar($query, $termino)
    {
        if ($termino) {
            return $query->where('nombre', 'LIKE', "%$termino%")
                ->orWhere('codigo', 'LIKE', "%$termino%")
                ->orWhere('categoria', 'LIKE', "%$termino%");
        }
        return $query;
    }

    public function detallesFacturasVenta()
    {
        return $this->hasMany(DetalleFacturaVenta::class);
    }

    public function ultimoDetalleFactura()
    {
        return $this->hasOne(DetalleFactura::class, 'product_id')
            ->latestOfMany();
    }
}
