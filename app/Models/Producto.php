<?php

namespace App\Models;



use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


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
        'precio_compra',
        'precio_venta'
    ];

    protected $casts = [
        'cantidad' => 'integer',
        'precio_compra' => 'decimal:2',
        'precio_venta' => 'decimal:2'
    ];

    /**
     * Define la relación uno a muchos con Detalle.
     */
    public function detalles()
    {
        return $this->hasMany(Detalle::class);
    }

    /**
     * Define la relación muchos a uno con Impuesto.
     * Un producto pertenece a un tipo de impuesto.
     */
    public function impuesto()
    {
        return $this->belongsTo(Impuesto::class);
    }

    public function precioCompras()
    {
        return $this->hasMany(PrecioCompra::class);
    }

    public function detallefactura()
    {
        return $this->hasMany(DetalleFacturaCompra::class, 'product_id');
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

    public function ultimoDetalleFactura()
    {
        return $this->hasOne(DetalleFacturaVenta::class)->latestOfMany();
    }




}
