<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'usuario'], function () use ($router) {
    $router->post('/registrar', 'Usuario\UsuarioController@ingresarUsuario');
    /*
    Entrada: json
    {
        "nombres": "",
        "apellidos": "",
        "email": "",
        "contrasena": ""
    }
    Salida:1
    {
        "salida" => true,
        "mensaje" => "usuario ingresado exitosamente",
        "usuario" => #
    }
    Salida:2
    {   
        "salida" => false,
        "mensaje" => "El usuario ya existe"
    }
    */
    $router->delete('/eliminar/{id}', 'Usuario\UsuarioController@eliminar');
    /*
    Entrada: en url
        int $id

    Salida1:
    {
        "mensaje": "El usuario fue eliminado exitosamente"
    }
    */
    $router->get('/obtener', 'Usuario\UsuarioController@obtenerUsuarios');
    /*
    Entrada: ninguno
    Salida:1
    {
        {
            "id": #
            "nombres": "",
            "apellidos": "",
            "email": "",
            "contrasena": ""
            "rol": #
            "estaEliminado": #
        },
        {
            ...
        },...
    }
    */
    $router->post('/validar','Usuario\UsuarioController@usuarioValido');
    /*
    Entrada: ninguno
    Salida:1
    {
        "salida" => true,
        "mensaje" => "Usuario y contrasena validos"
    }
    Salida:2
    {
        "salida" => false,
        "mensaje" => "Contrasena incorrecta del usuario"
    }
    Salida:3
    {
        "salida" => false,
        "mensaje" => "El correo no existe"
    }
    */
    $router->get('obtener/datos/{idUsuario}','Usuario\UsuarioController@obtenerDatosUsuario');
});

$router->group(['prefix' => 'prueba'], function () use ($router){
    $router->get("/obtener/{id}","Prueba\PruebaController@obtenerPrueba");
    $router->post('/ingresar','Prueba\PruebaController@ingresarPrueba');
});

$router->group(['prefix' => 'interes'], function () use ($router){
    $router->post('/ingresar','Usuario\InteresController@ingresarIntereses');
    $router->post('/usuario/ingresar','Usuario\InteresController@ingresarInteresesUsuario');
    $router->get('/obtener','Usuario\InteresController@obtenerIntereses');
    $router->delete('/eliminar/{id}','Usuario\InteresController@eliminarInteres');
});

$router->group(['prefix' => 'respuesta'], function () use ($router){
    $router->post('/ingresar','Usuario\RespuestaController@ingresarRespuestas');
});


