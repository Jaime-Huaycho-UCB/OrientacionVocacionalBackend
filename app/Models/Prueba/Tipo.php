<?php
namespace App\Models\Prueba;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;
class Tipo extends Model{
    use Authenticatable, Authorizable, HasFactory;

    public $timestamps = false;
    protected $table = 'TIPO';

    protected $primaryKey = 'id';

    protected $fillable = [
        'tipo'
    ];
}