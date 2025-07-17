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
        'precio_venta',
    ];

    protected $casts = [
        'cantidad' => 'integer',
        'precio_compra' => 'decimal:2',
        'precio_venta' => 'decimal:2',];

    /**
     * Defines the one-to-many relationship with Detalle.
     */
    public function detalles()
    {
        return $this->hasMany(Detalle::class);
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
        return $this->hasMany(PrecioCompra::class);
    }
}
