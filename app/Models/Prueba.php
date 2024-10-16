<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prueba extends Model
{
    protected $table = 'PRUEBA'; // Especificar la tabla

    protected $fillable = [
        'fecha','instrucciones'
    ];
}