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
                $usuario->contrasena = Hash::make($request->input("contrasena"));
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

    public function usuarioValido(Request $request){
        $email = $request->email;
        $contrasena = $request->contrasena;
        if ($this->existeUsuario($email)){
            $usuario = Usuario::where('email','=',$email)->first();
            if (Hash::check($contrasena,$usuario->contrasena)){
                return response()->json([
                    "salida" => true
                ],200);
            }else{
                return response()->json([
                    "salida" => false,
                    "mensaje" => "Contrasena incorrecta del usuario"
                ],400);
            }
        }else{  
            return response()->json([
                "salida" => false,
                "mensaje" => "EL correo no existe"
            ],404);
        }
    }
    
    public function existeUsuario(string $email){
        $respuesta = Usuario::where('email','=',$email)
                            ->first();
        if ($respuesta && $respuesta->estaEliminado==0){
            return true;
        }
        return false;
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
        $usuarios = Usuario::all();
        if ($usuarios->isNotEmpty()) {
            return response()->json($usuarios, 200);
        } else {
            return response()->json([
                'mensaje' => 'No se encontraron usuarios'
            ], 404);
        }
    }
    public function obtenerUsuariosHabilitados(){
        $usuarios = DB::table('USUARIO')->where('estaEliminado','=',0)->get();
        if ($usuarios) {
            return response()->json($usuarios, 200);
        } else {
            return response()->json([
                'mensaje' => 'No se encontraron usuarios'
            ], 404);
        }
    }
    public function obtenerUsuariosInhabilitados(){
        $usuarios = DB::table('USUARIO')->where('estaEliminado','=',1)->get();
        if ($usuarios) {
            return response()->json($usuarios, 200);
        } else {
            return response()->json([
                'mensaje' => 'No se encontraron usuarios'
            ], 404);
        }
    }
}