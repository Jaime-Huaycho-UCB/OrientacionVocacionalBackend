<?php

namespace App\Http\Controllers\Prueba;

use App\Http\Controllers\Controller;
use App\Models\Prueba\Pregunta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\Builder;
class PreguntaController extends Controller{
    public function obtenerPreguntas(int $prueba){
        $opcionController = new OpcionController();
        // $preguntas = DB::table("PREGUNTA")->select("contenido","tipo")->where("prueba","=",$prueba);
        $query = "SELECT id,contenido,tipo FROM PREGUNTA WHERE prueba=?";
        $preguntas= DB::select($query,[$prueba]);
        $salidaPreguntas = array();
        foreach ($preguntas as $pregunta){
            $opciones = $opcionController->obtenerOpciones($pregunta->id);
            $salidaOpciones = [
                "id" => $pregunta->id,
                "contenido" => $pregunta->contenido,
                "tipo" => $pregunta->tipo,
                "opciones" => $opciones
            ];
            array_push($salidaPreguntas,$salidaOpciones);
        }
        return $salidaPreguntas;
    }
}