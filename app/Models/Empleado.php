<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Empleado extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'apellido',
        'identidad',
        'direccion',
        'email',
        'telefono',
        'contactodeemergencia',
        'telefonodeemergencia',
        'tipodesangre',
        'departamento',
        'alergias',
        'alergiaOtros',
        'alergiaAlimentos',
        'alergiaMedicamentos',
        'categoria'
    ];
    protected $casts = [
        'alergias' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    public function instalaciones()
    {
        return $this->belongsToMany(Instalacion::class);
    }

    public function memorandosRecibidos()
    {
        return $this->hasMany(Memorando::class, 'destinatario_id');
    }

    public function memorandosCreados()
    {
        return $this->hasMany(Memorando::class, 'autor_id');
    }

    public function incapacidades()
    {
        return $this->hasMany(Incapacidad::class, 'empleado_id');
    }

    public function user()
    {
        return $this->hasOne(User::class);
    }




}
