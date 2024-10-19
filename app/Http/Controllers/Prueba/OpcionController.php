<?php

namespace App\Http\Controllers\Prueba;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OpcionController extends Controller{
    public function obtenerOpciones($pregunta){
        $query = "SELECT id,descripcion,inciso FROM OPCION WHERE pregunta = ?";
        $respuesta = DB::select($query,[$pregunta]);
        return $respuesta;
    }
}