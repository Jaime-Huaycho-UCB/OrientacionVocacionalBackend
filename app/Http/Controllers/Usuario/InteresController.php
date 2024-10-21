<?php

namespace App\Http\Controllers\Usuario;

use App\Http\Controllers\Controller;
use App\Models\Usuario\Interes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InteresController extends Controller{
    public function ingresarIntereses(Request $intereses){
        foreach ($intereses['intereses'] as $interes){
            $modelInteres = new Interes();
            $modelInteres->descripcion = $interes;
            $modelInteres->save();
        }
        return response()->json([
            "mensaje" => "Intereses cargados"
        ],200);
    }

    public function ingresarInteresesUsuario(Request $request){
        $interesesUsuarioController = new InteresesUsuarioController();
        $usuario = $request->input('usuario');
        $intereses = $request->input('intereses');
        foreach ($intereses as $descripcion){
            $idInteres = $this->obtenerInteres($descripcion);
            $interesesUsuarioController->ingresarInteresUsuario($usuario,$idInteres);
        }
        return response()->json([
            "mensaje" => "Intereses de usuario cargados"
        ],200);
    }

    public function obtenerInteres(string $descripcion){
        $interes = Interes::where('descripcion','=',$descripcion)
                            ->where('estaEliminado','=',0)
                            ->first();
        return $interes->id;
    }

    public function obtenerIntereses(){
        $intereses = Interes::where('estaEliminado','=',0)->get();
        if ($intereses->isNotEmpty()){
            return response()->json($intereses,200);
        }else{
            return response()->json([
                "mensaje" => "No existen intereses"
            ],404);
        }
    }

    public function obtenerInteresesUsuarioDatos(int $id){
        $interesesUsuarioController = new InteresesUsuarioController();
        $interesesUsuario = $interesesUsuarioController->obtenerInteresesUsuario($id) ;
        $salida = array();
        foreach ($interesesUsuario as $interesUsuario){
            $interesesDescripcion = Interes::find($interesUsuario['interes']);
            array_push($salida,$interesesDescripcion);
        }
        return $salida;
    }

    public function eliminarInteres(int $id){
        $interes = Interes::find($id);
        $interes->estaEliminado = 1;
        $interes->save();
        $interesesUsuarioController = new InteresesUsuarioController();
        $interesesUsuarioController->eliminarInteresesUsuario($id);
        return response()->json([
            "mensaje" => "Se elimino correctamente el interes $interes->descripcion"
        ],200);
    }
}