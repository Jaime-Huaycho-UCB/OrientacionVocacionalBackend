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
});