<?php

declare (strict_types = 1);

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

    Route::get('/prueba', function () {
        //rutas que no se evaluan en los permisos
        $except = ["auth.login", "auth.refresh", "auth.logout"];
        $routeName = json_encode(Route::getRoutes());
        foreach (Route::getRoutes() as $key => $value) {
            if (array_key_exists("as", $value["action"])) {
                $route = $value["action"]["as"];
                if(!in_array($route, $except)){
                    echo $route;
                }
            }
        }
    });
   
 $router->group(['prefix' => 'api/auth', "as" => "auth"], function ($router) {
        $router->post('register', ['as' => 'register', 'uses' => 'AuthController@register']);
        $router->post('login', ['as' => 'login', 'uses' => 'AuthController@login']);
        $router->post('logout', ['as' => 'logout', 'uses' => 'AuthController@logout']);
        $router->post('refresh', ['as' => 'refresh', 'uses' => 'AuthController@refresh']);
        $router->post('me', ['as' => 'me', 'uses' => 'AuthController@me']);
    });
    
$router->group(['prefix' => 'api', 'middleware' => ['auth.jwt', 'can_use_route']], function () use ($router) {
   
    $router->group(['prefix' => 'product', 'as' => "product"], function () use ($router) {
        $router->get('/', ['as' => 'index', 'uses' => 'ProductController@index']);
        $router->post('/', ['as' => 'store', 'uses' => 'ProductController@store']);
        $router->get('/{product}', ['as' => 'show', 'uses' => 'ProductController@show']);
        $router->patch('/{product}', ['as' => 'update', 'uses' => 'ProductController@update']);
        $router->delete('/{product}', ['as' => 'destroy', 'uses' => 'ProductController@destroy']);
    });

    $router->group(['prefix' => 'actoGrado', "as" => "acto-grado"], function () use ($router) {
        $router->get('/', ['as' => 'index', 'uses' => 'ActoGradoController@index']);
        $router->post('/', ['as' => 'store', 'uses' => 'ActoGradoController@store']);
        $router->get('/{actoGrado}', ['as' => 'show', 'uses' => 'ActoGradoController@show']);
        $router->patch('/{actoGrado}', ['as' => 'update', 'uses' => 'ActoGradoController@update']);
        $router->delete('/{actoGrado}', ['as' => 'destroy', 'uses' => 'ActoGradoController@destroy']);
    });
    $router->group(['prefix' => 'presentacionDep', "as" => "presentacion-dep"], function () use ($router) {
        $router->get('/', ['as' => 'index', 'uses' => 'PresentacionDepController@index']);
        $router->post('/', ['as' => 'store', 'uses' => 'PresentacionDepController@store']);
        $router->get('/{presentacionDep}', ['as' => 'show', 'uses' => 'PresentacionDepController@show']);
        $router->patch('/{presentacionDep}', ['as' => 'update', 'uses' => 'PresentacionDepController@update']);
        $router->delete('/{presentacionDep}', ['as' => 'destroy', 'uses' => 'PresentacionDepController@destroy']);
    });

    $router->group(['prefix' => 'evento', "as" => "evento"], function () use ($router) {
        $router->get('/', ['as' => 'index', 'uses' => 'EventoController@index']);
        $router->post('/', ['as' => 'store', 'uses' => 'EventoController@store']);
        $router->get('/{evento}', ['as' => 'show', 'uses' => 'EventoController@show']);
        $router->patch('/{evento}', ['as' => 'update', 'uses' => 'EventoController@update']);
        $router->delete('/{evento}', ['as' => 'destroy', 'uses' => 'EventoController@destroy']);
    });

    $router->group(['prefix' => 'actividadExtension', "as" => "actividad-extension"], function () use ($router) {
        $router->get('/', ['as' => 'index', 'uses' => 'ActividadExtensionController@index']);
        $router->post('/', ['as' => 'store', 'uses' => 'ActividadExtensionController@store']);
        $router->get('/{actividadExtension}', ['as' => 'show', 'uses' => 'ActividadExtensionController@show']);
        $router->patch('/{actividadExtension}', ['as' => 'update', 'uses' => 'ActividadExtensionController@update']);
        $router->delete('/{actividadExtension}', ['as' => 'destroy', 'uses' => 'ActividadExtensionController@destroy']);
    });

    $router->group(['prefix' => 'carrera', "as" => "carrera"], function () use ($router) {
        $router->get('/', ['as' => 'index', 'uses' => 'CarreraController@index']);
        $router->post('/', ['as' => 'store', 'uses' => 'CarreraController@store']);
        $router->get('/{carrera}', ['as' => 'show', 'uses' => 'CarreraController@show']);
        $router->patch('/{carrera}', ['as' => 'update', 'uses' => 'CarreraController@update']);
        $router->delete('/{carrera}', ['as' => 'destroy', 'uses' => 'CarreraController@destroy']);
    });

    $router->group(['prefix' => 'bolsaTrabajo', "as" => "bolsa-trabajo"], function () use ($router) {
        $router->get('/', ['as' => 'index', 'uses' => 'BolsaTrabajoController@index']);
        $router->post('/', ['as' => 'store', 'uses' => 'BolsaTrabajoController@store']);
        $router->get('/{bolsaTrabajo}', ['as' => 'show', 'uses' => 'BolsaTrabajoController@show']);
        $router->patch('/{bolsaTrabajo}', ['as' => 'update', 'uses' => 'BolsaTrabajoController@update']);
        $router->delete('/{bolsaTrabajo}', ['as' => 'destroy', 'uses' => 'BolsaTrabajoController@destroy']);
    });

    $router->group(['prefix' => 'egresado', "as" => "egresado"], function () use ($router) {
        $router->get('/', ['as' => 'index', 'uses' => 'EgresadoController@index']);
        $router->post('/', ['as' => 'store', 'uses' => 'EgresadoController@store']);
        $router->get('/{egresado}', ['as' => 'show', 'uses' => 'EgresadoController@show']);
        $router->patch('/{egresado}', ['as' => 'update', 'uses' => 'EgresadoController@update']);
        $router->delete('/{egresado}', ['as' => 'destroy', 'uses' => 'EgresadoController@destroy']);
    });

    $router->group(['prefix' => 'bolsaEgresado', "as" => "bolsa-egresado"], function () use ($router) {
        $router->get('/', ['as' => 'index', 'uses' => 'BolsaEgresadoController@index']);
        $router->post('/', ['as' => 'store', 'uses' => 'BolsaEgresadoController@store']);
        $router->get('/{bolsaEgresado}', ['as' => 'show', 'uses' => 'BolsaEgresadoController@show']);
        $router->patch('/{bolsaEgresado}', ['as' => 'update', 'uses' => 'BolsaEgresadoController@update']);
        $router->delete('/{bolsaEgresado}', ['as' => 'destroy', 'uses' => 'BolsaEgresadoController@destroy']);
    });

    $router->group(['prefix' => 'cuestionario', "as" => "cuestionario"], function () use ($router) {
        $router->get('/', ['as' => 'index', 'uses' => 'CuestionarioController@index']);
        $router->post('/', ['as' => 'store', 'uses' => 'CuestionarioController@store']);
        $router->get('/{cuestionario}', ['as' => 'show', 'uses' => 'CuestionarioController@show']);
        $router->patch('/{cuestionario}', ['as' => 'update', 'uses' => 'CuestionarioController@update']);
        $router->delete('/{cuestionario}', ['as' => 'destroy', 'uses' => 'CuestionarioController@destroy']);
    });

    $router->group(['prefix' => 'banco', "as" => "banco"], function () use ($router) {
        $router->get('/', ['as' => 'index', 'uses' => 'BancoController@index']);
        $router->post('/', ['as' => 'store', 'uses' => 'BancoController@store']);
        $router->get('/{banco}', ['as' => 'show', 'uses' => 'BancoController@show']);
        $router->patch('/{banco}', ['as' => 'update', 'uses' => 'BancoController@update']);
        $router->delete('/{banco}', ['as' => 'destroy', 'uses' => 'BancoController@destroy']);
    });


    $router->group(['prefix' => 'objetivoCuestionario', "as" => "objetivoCuestionario"], function () use ($router) {
        $router->get('/{cuestionario}', ['as' => 'show', 'uses' => 'ObjetivoController@show']);
    });

    $router->group(['prefix' => 'entry', "as" => "entry"], function () use ($router) {
        $router->get('/', ['as' => 'index', 'uses' => 'EntryController@index']);
    });
});
