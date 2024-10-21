<?php

namespace App\Models\Usuario;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Lumen\Auth\Authorizable;

class Resultado extends Model
{
    use Authenticatable, Authorizable, HasFactory;

    public $timestamps = false;
    protected $table = 'RESULTADO';
    protected $primaryKey = 'id';

    protected $fillable = [
        'resumenInteres','raonamientoVerbal','razonamientoNumerico','espacial','clerical','sugerenciaVocacional','usuario','estaEliminado'
    ];
}