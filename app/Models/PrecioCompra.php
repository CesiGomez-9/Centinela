<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrecioCompra extends Model
{
    use HasFactory;

    protected $fillable = [
        'producto_id',
        'precio_compra',
    ];

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}
