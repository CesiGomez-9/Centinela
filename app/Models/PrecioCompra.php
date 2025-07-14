<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrecioCompra extends Model
{
    use HasFactory;

    // Define los campos que pueden ser asignados masivamente.
    protected $fillable = [
        'producto_id',   // ID del producto al que pertenece este registro de precio.
        'precio_compra', // El precio de compra registrado.
    ];

    /**
     * Define la relación muchos a uno con Producto.
     * Un registro de PrecioCompra pertenece a un Producto.
     */
    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}
