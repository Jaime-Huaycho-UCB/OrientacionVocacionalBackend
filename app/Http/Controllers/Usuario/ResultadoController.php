<?php

namespace App\Http\Controllers\Usuario;

use App\Http\Controllers\Controller;
use App\Models\Usuario\Resultado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ResultadoController extends Controller{
    public function eliminarResultado(int $idUsuario){
        $resultado = Resultado::where('usuario','=',$idUsuario)->update([
            'estaEliminado' => 1
        ]);   
    }
}