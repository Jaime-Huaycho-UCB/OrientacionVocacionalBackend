<?php

namespace App\Http\Controllers;

use App\Models\Rol;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RolController extends Controller{
    public function existeRol(string $nombre){
        $rol = DB::table("ROL")->select("id","nombre")->where("nombre","=",$nombre)->first();
        if (!($rol)){
            return [
                "mensaje" => "No existe el rol ingresado para el usuario",
                "salida" => false
            ];
        }
        return [
            "id" => $rol->id,
            "nombre" => $rol->nombre,
            "salida" => true
        ];
    }
}