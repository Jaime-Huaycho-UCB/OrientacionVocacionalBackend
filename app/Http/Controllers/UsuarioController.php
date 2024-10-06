<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\Rol;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsuarioController extends Controller
{
    // Registro de usuarios (sign up)
    public function signup(Request $request)
    {
        // Validar los datos de entrada
        $this->validate($request, [
            'nombres' => 'required|string|max:200',
            'apellidos' => 'required|string|max:200',
            'email' => 'required|string|email|max:100|unique:USUARIO,email',
            'contrasena' => 'required|string|min:6',
            'rol_nombre' => 'required|string|exists:ROL,nombre' // Validar que el nombre del rol exista
        ]);

        // Obtener el ID del rol basado en el nombre proporcionado
        $rol = Rol::where('nombre', $request->input('rol_nombre'))->first();

        // Crear el usuario
        $usuario = new Usuario;
        $usuario->nombres = $request->input('nombres');
        $usuario->apellidos = $request->input('apellidos');
        $usuario->email = $request->input('email');
        $usuario->contrasena = $request->input('contrasena'); // Encriptar la contraseña
        $usuario->rol = $rol->id; // Guardar el ID del rol, no se ingresa manualmente, solo se relaciona
        $usuario->save();

        return response()->json([
            'message' => 'Usuario creado exitosamente!',
            'usuario' => $usuario->load('rol') // Cargar también el rol asociado
        ], 201);
    }

    // Inicio de sesión (login)
    public function login(Request $request)
    {
        // Validar los datos de entrada
        $this->validate($request, [
            'email' => 'required|string|email',
            'contrasena' => 'required|string',
        ]);

        // Verificar si el usuario existe
        $usuario = Usuario::where('email', $request->input('email'))->first();

        // Verificar la contraseña
        if ($usuario &&($request->input('contrasena') == $usuario->contrasena)) {
            // Generar un token (en un caso real podrías usar JWT)
            $token = Str::random(60);

            return response()->json([
                'message' => 'Login exitoso!',
                'usuario' => $usuario->load('rol'), // Cargar también el rol asociado
                'token' => $token
            ], 200);
        }

        return response()->json([
            'message' => 'Correo o contraseña incorrectos'
        ], 401);
    }
}