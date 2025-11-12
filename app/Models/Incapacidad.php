<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;


class Incapacidad extends Model
{
    use HasFactory;

    protected $table = 'incapacidades';


    protected $fillable = [
        'empleado_id',
        'motivo',
        'descripcion',
        'fecha_inicio',
        'fecha_fin',
        'documento',
        'institucion_medica',
    ];



    public function empleado()
    {
        return $this->belongsTo(Empleado::class);
    }

    public function getEstadoAttribute()
    {
        $hoy = now();
        $fechaInicio = Carbon::parse($this->fecha_inicio);
        $fechaFin = Carbon::parse($this->fecha_fin);

        if ($fechaFin->lt($hoy)) {
            return 'Finalizada';
        } elseif ($fechaInicio->lte($hoy) && $fechaFin->gte($hoy)) {
            return 'Vigente';
        } else {
            return 'Pendiente';
        }
    }

}
