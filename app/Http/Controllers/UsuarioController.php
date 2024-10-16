<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\Rol;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Http\Controllers\RolController;
use Exception;
use Symfony\Component\Console\Input\Input;
use Illuminate\Support\Facades\DB;


class UsuarioController extends Controller{
    public function ingresarUsuario(Request $request){
        $rolController = new RolController();
        $usuario = new Usuario();
        $rol = $request->input("rol");
        $email = $request->input("email");
        $respuesta = UsuarioController::existeUsuario($email);
        if (!($respuesta["existe"])){
            $respuesta=$rolController->existeRol($rol);
            if ($respuesta['salida']){
                $usuario->nombres = $request->input("nombres");
                $usuario->apellidos = $request->input("apellidos");
                $usuario->email = $request->input("email");
                $usuario->contrasena = $request->input("contrasena");
                $usuario->rol=$respuesta['id'];
                try{
                    $usuario->save();
                    return response()->json([
                        "mensaje" => "usuario ingresado exitosamente"
                    ],200);
                }catch(Exception $error){
                    return response()->json([
                        "Error" => $error
                    ],500);
                }
            }else{
                return response()->json([
                    "mensaje" => $respuesta["mensaje"]
                ],500);
            }
        }else{
            return response()->json([
                "mensaje" => $respuesta["mensaje"]
            ]);
        }
    } 
    
    public function existeUsuario(string $email){
        $usuario = new Usuario();
        $respuesta = DB::table("USUARIO")->where("email","=",$email)->first();
        if ($respuesta){
            return [
                "existe" => true,
                "mensaje" => "El usuario ingresado ya existe"
            ];
        }
        return [
            "existe" => false,
        ];
    }
}