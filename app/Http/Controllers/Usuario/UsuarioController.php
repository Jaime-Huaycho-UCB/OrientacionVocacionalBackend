<?php

namespace App\Http\Controllers\Usuario;

use App\Models\Usuario\Usuario;
use App\Http\Controllers\Controller;
use App\Models\Usuario\Rol;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Http\Controllers\Usuario\RolController;
use Illuminate\Support\Facades\DB;


class UsuarioController extends Controller{
    public function ingresarUsuario(Request $request){
        $rolController = new RolController();
        $usuario = new Usuario();
        $rol = $request->input("rol");
        $email = $request->input("email");
        if (!($this->existeUsuario($email))){
            $respuesta=$rolController->existeRol($rol);
            if ($respuesta){
                $usuario->nombres = $request->input("nombres");
                $usuario->apellidos = $request->input("apellidos");
                $usuario->email = $request->input("email");
                $usuario->contrasena = $request->input("contrasena");
                $usuario->rol=$respuesta->id;
                $usuario->save();
                return response()->json([
                    "mensaje" => "usuario ingresado exitosamente"
                ],200);
            }else{
                return response()->json([
                    "mensaje" => "El rol ingresado es invalido"
                ],500);
            }
        }else{
            return response()->json([
                "mensaje" => "El usuario ya existe"
            ]);
        }
    } 
    
    public function existeUsuario(string $email){
        return Usuario::where('email',$email)->first();
    }
    public function existe(Request $request){
        if ($this->existeUsuario($request->input("email"))){
            return response()->json([
                "salida" => true
            ],200);
        }else{
            return response()->json([
                "salida" => false,
                "mensaje" => "El correo no existe"
            ],200);
        }
    }

    public function eliminar($id){
        $mensaje = $this->eliminarUsuario($id);
        return response()->json([
            "mensaje" => $mensaje
        ],200);
    }

    public function eliminarUsuario($id){
        $usuario = Usuario::find($id);
        $usuario->estaEliminado = 1;
        $usuario->save();
        return "El usuario fue eliminado exitosamente";
    }

    public function obtenerUsuarios(){
        $usuario = Usuario::all();
        if ($usuario){
            return response()->json($usuario,200);
        }
    }
}