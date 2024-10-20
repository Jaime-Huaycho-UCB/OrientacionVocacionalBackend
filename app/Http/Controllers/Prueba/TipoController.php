<?php

namespace App\Http\Controllers\Prueba;

use App\Http\Controllers\Controller;
use App\Models\Prueba\Tipo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TipoController extends Controller{

    public function obtenerNombre(int $id){
        $tipo = Tipo::find($id);
        return $tipo->tipo;
    }
    public function obtenerTipos(){
        $respuesta = Tipo::all();
        if ($respuesta){
            return response()->json($respuesta,200);
        }else{
            return response()->json([
                "mensaje" => "No hay tipos"
            ],500);
        }
    }

    public function existeTipo(string $tipo){
        $resultado = Tipo::where("tipo","=",$tipo)->first();
        return $resultado;
    }

    public function ingresarTipo(string $tipo){
        $tipoSalida = $this->existeTipo($tipo);
        if ($tipoSalida){
            return $tipoSalida->id;
        }
        $modelTipo = new Tipo();
        $modelTipo->tipo=$tipo;
        $modelTipo->save();
        return $modelTipo->id;
    }
}