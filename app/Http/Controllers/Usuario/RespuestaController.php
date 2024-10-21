<?php

namespace App\Http\Controllers\Usuario;

use App\Http\Controllers\Controller;
use App\Models\Usuario\Respuesta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RespuestaController extends Controller{
    public function ingresarRespuestas(Request $request){
        $usuario = $request->input('usuario');
        $idRespuestas = $request->input('respuestas');
        foreach ($idRespuestas as $opcion){
            $respuesta = new Respuesta();
            $respuesta->usuario = $usuario;
            $respuesta->opcion = $opcion;
            $respuesta->save();
        }
        return response()->json([
            "mensaje" => "Respuestas ingresadas exitosamente"
        ],200);
    }

    public function eliminarRespuesta($usuario){
        $respuesa = Respuesta::where('usuario','=',$usuario)->update([
            "estaEliminado" => 1
        ]);
    }

    public function obtenerRespuesta(int $idUsuario){
        $respuestas = Respuesta::where('usuario','=',$idUsuario)->get();
        return $respuestas;
    }
}