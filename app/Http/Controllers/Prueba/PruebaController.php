<?php

namespace App\Http\Controllers\Prueba;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Prueba\PreguntaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PruebaController extends Controller{

    public function obtenerPrueba(int $id){
        $preguntaController = new PreguntaController();
        $condicion = $this->existePrueba($id);
        if ($condicion['salida']){
            $preguntas=$preguntaController->obtenerPreguntas($id);
            return response()->json([
                "id" => $id,
                "instrucciones" => $condicion['instrucciones'],
                "preguntas" => $preguntas
            ],200);
        }else{
            return response()->json([
                "salida" => false,
                "mensaje" => "La prueba no existe"
            ],500);
        }
    }

    public function existePrueba(int $id){
        $respuesta = DB::table("PRUEBA")->select("id","instrucciones")->where("id","=",$id)->first();
        if ($respuesta){
            return [
                "salida" => true,
                "instrucciones" => $respuesta->instrucciones
            ];
        }else{
            return [
                "salida" => false,
            ];
        }
    }
}