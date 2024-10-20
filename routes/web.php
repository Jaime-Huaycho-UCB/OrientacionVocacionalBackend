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

$router->get("/prueba/obtener/{id}","Prueba\PruebaController@obtenerPrueba");

$router->group(['prefix' => 'usuario'], function () use ($router) {
    $router->post('/registrar', 'Usuario\UsuarioController@ingresarUsuario');
    $router->post('/existe', 'Usuario\UsuarioController@existe');
    $router->delete('/eliminar/{id}', 'Usuario\UsuarioController@eliminar');
    $router->get('/obtener', 'Usuario\UsuarioController@obtenerUsuarios');
    $router->get('/obtener/habilitados', 'Usuario\UsuarioController@obtenerUsuariosHabilitados');
    $router->get('/obtener/inhabilitados', 'Usuario\UsuarioController@obtenerUsuariosInhabilitados');
    $router->post('/validar','Usuario\UsuarioController@usuarioValido');
});

$router->group(['prefix' => 'rol'], function () use ($router) {
    $router->post('/ingresar', 'Usuario\RolController@ingresarRol');
    $router->get('/obtener','Usuario\RolController@obtenerRoles');
});

$router->group(['prefix' => 'prueba'], function () use ($router){
    $router->get("/obtener/{id}","Prueba\PruebaController@obtenerPrueba");
    $router->post('/ingresar','Prueba\PruebaController@ingresarPrueba');
});

