<?php

namespace App\Http\Controllers\Prueba;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Prueba\TipoController;
use App\Models\Prueba\Opcion;
use App\Models\Prueba\Pregunta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class PreguntaController extends Controller{
    public function obtenerPreguntas(int $prueba){
        $tipoController = new TipoController();
        $opcionController = new OpcionController();
        $preguntas = Pregunta::where("prueba","=",$prueba)->get();
        $salidaPreguntas = array();
        foreach ($preguntas as $pregunta){
            $opciones = $opcionController->obtenerOpciones($pregunta->id);
            $nombreTipo = $tipoController->obtenerNombre($pregunta->tipo);
            $salidaOpciones = [
                "id" => $pregunta->id,
                "contenido" => $pregunta->contenido,
                "tipo" => $nombreTipo,
                "opciones" => $opciones
            ];
            array_push($salidaPreguntas,$salidaOpciones);
        }
        return $salidaPreguntas;
    }


    public function ingresarPreguntas(array $preguntas,int $prueba){
        foreach ($preguntas as $pregunta){
            $tipoController = new TipoController();
            $idTipo = $tipoController->ingresarTipo($pregunta['tipo']);
            $modelPregunta = new Pregunta();
            $modelPregunta->contenido = $pregunta['contenido'];
            $modelPregunta->tipo=$idTipo;
            $modelPregunta->prueba = $prueba;
            $modelPregunta->save();
            $idPregunta = $modelPregunta->id;
            $opcionController = new OpcionController();
            $opcionController->ingresarOpciones($pregunta['opciones'],$idPregunta);
        }
    }
}