<?php

declare(strict_types = 1);

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
//$router->group(['prefix' => 'api', 'middleware' => ['client.credentials']], function () use ($router) {
$router->group(['prefix' => 'api'], function () use ($router) {

    $router->group(['prefix' => 'product'], function () use ($router) {
        $router->get('/', ['uses' => 'ProductController@index']);
        $router->post('/', ['uses' => 'ProductController@store']);
        $router->get('/{product}', ['uses' => 'ProductController@show']);
        $router->patch('/{product}', ['uses' => 'ProductController@update']);
        $router->delete('/{product}', ['uses' => 'ProductController@destroy']);
    });

    $router->group(['prefix' => 'actoGrado'], function () use ($router) {
        $router->get('/', ['uses' => 'ActoGradoController@index']);
        $router->post('/', ['uses' => 'ActoGradoController@store']);
        $router->get('/{actoGrado}', ['uses' => 'ActoGradoController@show']);
        $router->patch('/{actoGrado}', ['uses' => 'ActoGradoController@update']);
        $router->delete('/{actoGrado}', ['uses' => 'ActoGradoController@destroy']);
    });
    $router->group(['prefix' => 'presentacionDep'], function () use ($router) {
        $router->get('/', ['uses' => 'PresentacionDepController@index']);
        $router->post('/', ['uses' => 'PresentacionDepController@store']);
        $router->get('/{presentacionDep}', ['uses' => 'PresentacionDepController@show']);
        $router->patch('/{presentacionDep}', ['uses' => 'PresentacionDepController@update']);
        $router->delete('/{presentacionDep}', ['uses' => 'PresentacionDepController@destroy']);
    });

    $router->group(['prefix' => 'evento'], function () use ($router) {
        $router->get('/', ['uses' => 'EventoController@index']);
        $router->post('/', ['uses' => 'EventoController@store']);
        $router->get('/{evento}', ['uses' => 'EventoController@show']);
        $router->patch('/{evento}', ['uses' => 'EventoController@update']);
        $router->delete('/{evento}', ['uses' => 'EventoController@destroy']);
    });

    $router->group(['prefix' => 'actividadExtension'], function () use ($router) {
        $router->get('/', ['uses' => 'ActividadExtensionController@index']);
        $router->post('/', ['uses' => 'ActividadExtensionController@store']);
        $router->get('/{actividadExtension}', ['uses' => 'ActividadExtensionController@show']);
        $router->patch('/{actividadExtension}', ['uses' => 'ActividadExtensionController@update']);
        $router->delete('/{actividadExtension}', ['uses' => 'ActividadExtensionController@destroy']);
    });

    $router->group(['prefix' => 'carrera'], function () use ($router) {
        $router->get('/', ['uses' => 'CarreraController@index']);
        $router->post('/', ['uses' => 'CarreraController@store']);
        $router->get('/{carrera}', ['uses' => 'CarreraController@show']);
        $router->patch('/{carrera}', ['uses' => 'CarreraController@update']);
        $router->delete('/{carrera}', ['uses' => 'CarreraController@destroy']);
    });

    $router->group(['prefix' => 'bolsaTrabajo'], function () use ($router) {
        $router->get('/', ['uses' => 'BolsaTrabajoController@index']);
        $router->post('/', ['uses' => 'BolsaTrabajoController@store']);
        $router->get('/{bolsaTrabajo}', ['uses' => 'BolsaTrabajoController@show']);
        $router->patch('/{bolsaTrabajo}', ['uses' => 'BolsaTrabajoController@update']);
        $router->delete('/{bolsaTrabajo}', ['uses' => 'BolsaTrabajoController@destroy']);
    });

    $router->group(['prefix' => 'egresado'], function () use ($router) {
        $router->get('/', ['uses' => 'EgresadoController@index']);
        $router->post('/', ['uses' => 'EgresadoController@store']);
        $router->get('/{egresado}', ['uses' => 'EgresadoController@show']);
        $router->patch('/{egresado}', ['uses' => 'EgresadoController@update']);
        $router->delete('/{egresado}', ['uses' => 'EgresadoController@destroy']);
    });

    $router->group(['prefix' => 'bolsaEgresado'], function () use ($router) {
        $router->get('/', ['uses' => 'BolsaEgresadoController@index']);
        $router->post('/', ['uses' => 'BolsaEgresadoController@store']);
        $router->get('/{bolsaEgresado}', ['uses' => 'BolsaEgresadoController@show']);
        $router->patch('/{bolsaEgresado}', ['uses' => 'BolsaEgresadoController@update']);
        $router->delete('/{bolsaEgresado}', ['uses' => 'BolsaEgresadoController@destroy']);
    });

    $router->group(['prefix' => 'cuestionario'], function () use ($router) {
        $router->get('/', ['uses' => 'CuestionarioController@index']);
        $router->post('/', ['uses' => 'CuestionarioController@store']);
        $router->get('/{cuestionario}', ['uses' => 'CuestionarioController@show']);
        $router->patch('/{cuestionario}', ['uses' => 'CuestionarioController@update']);
        $router->delete('/{cuestionario}', ['uses' => 'CuestionarioController@destroy']);
    });

    $router->group(['prefix' => 'entry'], function () use ($router) {
        $router->get('/', ['uses' => 'EntryController@index']);
    });

});
