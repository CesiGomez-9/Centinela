<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Impuesto extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'porcentaje',
    ];

    /**
     * Get the products for the Impuesto.
     */
    public function productos()
    {
        return $this->hasMany(Producto::class);
    }
}
