<?php

namespace App\Http\Controllers\Usuario;

use App\Http\Controllers\Prueba\OpcionController;
use App\Http\Controllers\Prueba\PreguntaController;
use App\Http\Controllers\Prueba\PruebaController;
use App\Models\Usuario\Usuario;
use App\Http\Controllers\Controller;
use App\Models\Usuario\Rol;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Http\Controllers\Usuario\RolController;
use App\Models\Usuario\Respuesta;
use Illuminate\Support\Facades\DB;


class UsuarioController extends Controller{
    public function ingresarUsuario(Request $request){
        $rolController = new RolController();
        $usuario = new Usuario();
        $email = $request->input("email");
        if (!($this->existeUsuario($email))){
            $respuesta=$rolController->existeRol("Usuario");
            $usuario->nombres = $request->input("nombres");
            $usuario->apellidos = $request->input("apellidos");
            $usuario->email = $request->input("email");
            $usuario->contrasena = Hash::make($request->input("contrasena"));
            $usuario->rol=$respuesta->id;
            $usuario->save();
            return response()->json([
                "salida" => true,
                "mensaje" => "usuario ingresado exitosamente",
                "usuario" => $usuario->id
            ],200);
        }else{
            return response()->json([
                "salida" => false,
                "mensaje" => "El usuario ya existe"
            ],409);
        }
    } 

    public function usuarioValido(Request $request){
        $email = $request->email;
        $contrasena = $request->contrasena;
        $usuario = Usuario::where('email','=',$email)->where('rol','=',2)->first();
        if ($usuario){
            if (Hash::check($contrasena,$usuario->contrasena)){
                return response()->json([
                    "salida" => true,
                    "mensaje" => "Usuario y contrasena validos"
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
        $respuestaController = new RespuestaController();
        $resultadoController = new ResultadoController();
        $interesUsuarioController = new InteresesUsuarioController();
        $resultadoController->eliminarResultado($id);
        $respuestaController->eliminarRespuesta($id);
        $interesUsuarioController->eliminarInteresesUsuario($id);
        return "El usuario fue eliminado exitosamente";
    }

    public function obtenerUsuarios(){
        $usuarios = Usuario::where('estaEliminado','=',0)
                    ->where('rol','=',3)
                    ->get();
        if ($usuarios->isNotEmpty()) {
            return response()->json($usuarios, 200);
        } else {
            return response()->json([
                'mensaje' => 'No se encontraron usuarios'
            ], 404);
        }
    }

    public function obtenerDatosUsuario(int $idUsuario){
        $pruebaController = new PruebaController();
        $interesController = new InteresController();
        $respuestaController = new RespuestaController();
        $preguntaController = new PreguntaController();
        $opcionController = new OpcionController();
        $usuario = Usuario::find($idUsuario);
        $arraySalida = array();
        $respuestas = $respuestaController->obtenerRespuesta($idUsuario);
        $intereses = $interesController->obtenerInteresesUsuarioDatos($idUsuario);
        $idPrueba = 0;
        foreach ($respuestas as $opcion){
            $opcionData = $opcionController->obtenerOpcion($opcion['opcion']);
            $pregunta = $preguntaController->obtenerPregunta($opcionData['pregunta']);
            $idPrueba = $pregunta['prueba'];
            $salidaPreguntaRespuesta = [
                "id" => $pregunta['id'],
                "contenido" => $pregunta['contenido'],
                "respuesta" => $opcionData
            ];
            array_push($arraySalida,$salidaPreguntaRespuesta);
        }
        $prueba = $pruebaController->obtenerPruebaDatos($idPrueba);
        $salida = [
            "nombres" => $usuario->nombres,
            "apellidos" => $usuario->apellidos,
            "email" => $usuario->email,
            "intereses" => $intereses,
            "prueba" => [
                "instrucciones" => $prueba->instrucciones,
                "preguntas" => $arraySalida
            ]
        ];
        return response()->json($salida,200);
    }
}