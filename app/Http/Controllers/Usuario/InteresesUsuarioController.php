<?php

namespace App\Http\Controllers\Usuario;

use App\Http\Controllers\Controller;
use App\Models\Usuario\Interes;
use App\Models\Usuario\InteresesUsuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InteresesUsuarioController extends Controller{
    
    public function ingresarInteresUsuario(int $usuario,int $interes){
        $interesesUsuario = new InteresesUsuario();
        $interesesUsuario->usuario = $usuario;
        $interesesUsuario->interes = $interes;
        $interesesUsuario->save();        
    }

    public function eliminarInteresesUsuario(int $idInteres){
        $respuesa = InteresesUsuario::where('interes','=',$idInteres)->update([
            "estaEliminado" => 1
        ]);
    }

    public function obtenerInteresesUsuario(int $id){
        $interesesUsuario = InteresesUsuario::where('usuario','=',$id);
        return $interesesUsuario;
    }
}