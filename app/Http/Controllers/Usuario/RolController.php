<?php

namespace App\Http\Controllers\Usuario;

use App\Models\Usuario\Rol;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RolController extends Controller{
    public function existeRol(string $nombre){
        return Rol::where('nombre',$nombre)->first();
    }
}