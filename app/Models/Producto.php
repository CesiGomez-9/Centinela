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
    ];

    protected $casts = [
        'cantidad' => 'integer',
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
}
