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

    public function obtenerRoles(){
        $roles = Rol::all();
        if ($roles){
            return response()->json($roles,200);
        }else{
            return response()->json([
                "mensaje" => "No hay roles en la base de datos"
            ],404);
        }
    }

    public function ingresarRol(Request $request){
        if ($this->existeRol($request->nombre)){
            return response()->json([
                "mensaje" => "EL rol ingresado ya existe"
            ],409);
        }else{
            $rol = new Rol();
            $rol->nombre=$request->nombre;
            $rol->save();
            return response()->json([
                "mensaje" => "El rol fue ingresado exitosamente"
            ],200);
        }
    }
}