<?php

namespace App\Http\Controllers\Usuario;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TipoController extends Controller{
    public function getAll(){
        $respuesta = DB::table("TIPO")->select("id","tipo");
        if ($respuesta){
            return response()->json($respuesta,200);
        }else{
            return response()->json([
                "mensaje" => "Error al intentar obtener todos los tipos de preguntas"
            ],500);
        }
    }

    public function existeTipo(string $tipo){
        $resultado = DB::table("TIPO")->select("id","tipo")->where("tipo","=",$tipo)->first();
        if ($resultado){
            return [
                "salida" => true,
                "id" => $resultado->tipo
            ];
        }else{
            return [
                "salida" => false,
                "mensaje" => "no existe el tipo de pregunta"
            ];
        }
    }
}