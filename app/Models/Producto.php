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
        'precio_compra', // New field added
        'precio_venta',  // New field added
    ];

    protected $casts = [
        'cantidad' => 'integer',
        'precio_compra' => 'decimal:2', // Ensures it's handled as a decimal with 2 places.
        'precio_venta' => 'decimal:2',  // Ensures it's handled as a decimal with 2 places.
    ];

    /**
     * Defines the one-to-many relationship with Detalle.
     */
    public function detalles()
    {
        return $this->hasMany(Detalle::class);
    }

    public function detallesFactura()
    {
        return $this->hasMany(DetalleFactura::class, 'product_id');
    }


    /**
     * Defines the many-to-one relationship with Impuesto.
     * A product belongs to one tax type.
     */
    public function impuesto()
    {
        return $this->belongsTo(Impuesto::class);
    }

    /**
     * Defines the one-to-many relationship with PrecioCompra.
     * A product can have many historical purchase price records.
     */
    public function precioCompras()
    {
        // Orders by creation date in descending order to show the most recent first.
        return $this->hasMany(PrecioCompra::class)->orderBy('created_at', 'desc');
    }

}
