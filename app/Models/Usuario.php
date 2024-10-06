<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;

class Usuario extends Model
{
    use Authenticatable, Authorizable, HasFactory;

    public $timestamps = false;
    protected $table = 'USUARIO'; // Especificar la tabla si no sigue las convenciones de Laravel

    protected $fillable = [
        'nombres', 'apellidos', 'email', 'contrasena', 'rol'
    ];

    protected $hidden = [
        'contrasena',
    ];

    // Relación con la tabla ROL
    public function rol()
    {
        return $this->belongsTo(Rol::class, 'rol');
    }
}