<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;


    protected $fillable = [
        'empleado_id',
        'usuario',
        'email',
        'password',
        'rol',
        'two_factor_secret',
        'two_factor_enabled',
        'two_factor_recovery_codes',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_secret',
        'two_factor_recovery_codes',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
            'two_factor_enabled' => 'boolean',
        ];
    }

    public function hasTwoFactorEnabled(): bool
    {
        return $this->two_factor_enabled && !empty($this->two_factor_secret);
    }

    public function requiresTwoFactor(): bool
    {
        return in_array($this->rol, ['super_admin', 'administrador']);
    }

    public function empleado()
    {
        return $this->belongsTo(Empleado::class);
    }

    protected static function booted()
    {
        static::creating(function ($user) {
            if (empty($user->usuario) && $user->empleado) {
                $nombre = strtolower(explode(' ', $user->empleado->nombre)[0]);
                $apellido = strtolower(explode(' ', $user->empleado->apellido)[0]);
                $user->usuario = $nombre . '.' . $apellido;

                // Evitar duplicados
                $base = $user->usuario;
                $contador = 1;
                while (User::where('usuario', $user->usuario)->exists()) {
                    $user->usuario = $base . $contador;
                    $contador++;
                }
            }
        });
    }


    public function username()
    {
        return 'usuario';
    }

}
