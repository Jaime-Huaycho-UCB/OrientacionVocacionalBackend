<?php

namespace App\Http\Controllers\Prueba;

use App\Http\Controllers\Controller;
use App\Models\Prueba\Opcion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OpcionController extends Controller{
    public function obtenerOpciones($pregunta){
        $query = "SELECT id,descripcion,inciso FROM OPCION WHERE pregunta = ?";
        $respuesta = DB::select($query,[$pregunta]);
        return $respuesta;
    }

    public function ingresarOpciones(array $opciones,int $pregunta){
        foreach ($opciones as $opcion){
            $modelOpcion = new Opcion();
            $modelOpcion->descripcion = $opcion['descripcion'];
            $modelOpcion->inciso = $opcion['inciso'];
            $modelOpcion->pregunta = $pregunta;
            $modelOpcion->save();
        }
    }

    public function obtenerOpcion(int $idOpcion){
        $opcion = Opcion::find($idOpcion);
        return $opcion;
    }
}