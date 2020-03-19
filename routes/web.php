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

$router->get('/trades/{userId}', [
    'as' => 'trade', 'uses' => 'Trade@index'
]);

$router->post('/trade', [
    'as' => 'trade', 'uses' => 'Trade@post'
]);

$router->put('/trade/{id}', [
    'as' => 'trade', 'uses' => 'Trade@put'
]);

$router->delete('/trade/{id}', [
    'as' => 'trade', 'uses' => 'Trade@delete'
]);

$router->get('/category', [
    'as' => 'category', 'uses' => 'Category@index'
]);

$router->post('/category', [
    'as' => 'category', 'uses' => 'Category@post'
]);

$router->put('/category/{id}', [
    'as' => 'category', 'uses' => 'Category@put'
]);

$router->delete('/category/{id}', [
    'as' => 'category', 'uses' => 'Category@delete'
]);

Route::group([

    /* 'middleware' => 'api', */
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');

});

$router->post('/user', [
    'as' => 'user', 'uses' => 'User@post'
]);
