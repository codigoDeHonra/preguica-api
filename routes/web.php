<?php

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

$router->get('/check', function () use ($router) {
    return $router->app->version();
});

$router->get('/db', function () use ($router) {
    dd(DB::collection('trades')->get());
});

/* $router->get('/trades', [ */
/*     'as' => 'trades', 'uses' => 'ExampleController@trades' */
/* ]); */

$router->post('/trade', [
    'as' => 'trade', 'uses' => 'Trade@post'
]);

$router->get('/trades', [
    'as' => 'trade', 'uses' => 'Trade@index'
]);

$router->delete('/trade/{id}', [
    'as' => 'trade', 'uses' => 'Trade@delete'
]);
