<?php

namespace App\Models\Usuario;

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
    protected $table = 'USUARIO';

    protected $primaryKey = 'id';

    protected $fillable = [
        'nombres', 'apellidos', 'email', 'contrasena', 'rol','estaEliminado'
    ];

    protected $hidden = [
        'contrasena',
    ];
    
}