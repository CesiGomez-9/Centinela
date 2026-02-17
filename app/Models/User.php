<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable;


    protected $fillable = [
        'empleado_id',
        'usuario',
        'email',
        'password',
        'rol',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
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


    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_user', 'user_id', 'role_id');
    }


    public function hasRole($role)
    {
        return $this->roles()->where('nombre', $role)->exists();
    }

    public function username()
    {
        return 'usuario';
    }

}
