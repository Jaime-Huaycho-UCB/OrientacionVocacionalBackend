<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    protected $table = 'ROL'; // Especificar la tabla

    protected $fillable = [
        'nombre',
    ];

    // Relación con la tabla USUARIO
    public function usuarios()
    {
        return $this->hasMany(Usuario::class, 'rol');
    }
}