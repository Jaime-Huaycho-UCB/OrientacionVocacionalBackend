<?php

namespace App\Http\Controllers;

use App\Models\Rol;
use Illuminate\Http\Request;

class RolController extends Controller
{
    // Obtener todos los roles
    public function index()
    {
        $roles = Rol::all();
        return response()->json($roles);
    }

    // Crear un nuevo rol
    public function store(Request $request)
    {
        $this->validate($request, [
            'nombre' => 'required|string|max:100',
        ]);

        $rol = new Rol;
        $rol->nombre = $request->input('nombre');
        $rol->save();

        return response()->json([
            'message' => 'Rol creado exitosamente!',
            'rol' => $rol
        ], 201);
    }
}