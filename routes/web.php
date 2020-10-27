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

/* $router->get('/excel', [ */
/*     'middleware' => 'auth', */
/*     'as' => 'trade', 'uses' => 'Trade@excel' */
/* ]); */

$router->post('/excel', [
    /* 'middleware' => 'auth', */
    'as' => 'trade', 'uses' => 'Trade@excel'
]);

/* $router->get('/company', [ */
/*     /1* 'middleware' => 'auth', *1/ */
/*     'as' => 'trade', 'uses' => 'Trade@company' */
/* ]); */

$router->get('/company', [
    /* 'middleware' => 'auth', */
    'as' => 'company', 'uses' => 'Company@index'
]);

$router->get('/company/assets', [
    /* 'middleware' => 'auth', */
    'as' => 'company', 'uses' => 'Company@assets'
]);

$router->get('/ticker', [
    'as' => 'trade', 'uses' => 'Trade@ticker'
]);

$router->get('/cedro', [
    'as' => 'trade', 'uses' => 'Trade@cedro'
]);

$router->get('/trades/count', [
    'as' => 'trade', 'uses' => 'Trade@count'
]);

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

$router->get('/category/wallet/{walletId}', [
    'as' => 'category-by-wallet', 'uses' => 'Category@byWallet'
]);

$router->get('/broker', [
    'as' => 'category', 'uses' => 'Broker@index'
]);

$router->post('/broker', [
    'as' => 'category', 'uses' => 'Broker@post'
]);

$router->put('/broker/{id}', [
    'as' => 'category', 'uses' => 'Broker@put'
]);

$router->delete('/broker/{id}', [
    'as' => 'category', 'uses' => 'Broker@delete'
]);

$router->get('/asset', [
    'as' => 'category', 'uses' => 'Asset@index'
]);
$router->get('/asset/{code}', [
    'as' => 'category', 'uses' => 'Asset@show'
]);

$router->post('/asset', [
    'as' => 'category', 'uses' => 'Asset@post'
]);

$router->put(
    '/asset',
    [
        'as' => 'asset',
        'uses' => 'Asset@put'
    ]
);

$router->delete('/asset/{id}', [
    'as' => 'category', 'uses' => 'Asset@delete'
]);

$router->get('/study/{code}', [
    'as' => 'study', 'uses' => 'Study@index'
]);

$router->post('/study', [
    'middleware' => 'auth',
    'as' => 'study', 'uses' => 'Study@post'
]);

$router->get('/wallet/profile/{profileId}', [
    'as' => 'wallet', 'uses' => 'Wallet@index'
]);

$router->get('/wallet/count/profile/{profileId}', [
    'as' => 'wallet', 'uses' => 'Wallet@count'
]);

$router->post('/wallet', [
    'as' => 'wallet', 'uses' => 'Wallet@post'
]);

$router->put('/wallet/{id}', [
    'as' => 'wallet', 'uses' => 'Wallet@put'
]);

$router->delete('/wallet/{id}', [
    'as' => 'wallet', 'uses' => 'Wallet@delete'
]);

$router->get('/profile/user/{userId}', [
    'as' => 'profile', 'uses' => 'Profile@index'
]);

$router->get('/profile/count', [
    'as' => 'profile', 'uses' => 'Profile@count'
]);

$router->get('/profile/{code}', [
    'as' => 'profile', 'uses' => 'Profile@show'
]);

$router->post('/profile', [
    'middleware' => 'auth',
    'as' => 'profile',
    'uses' => 'Profile@post'
]);

$router->put('/profile/{id}', [
    'as' => 'profile', 'uses' => 'Profile@put'
]);

$router->delete('/profile/{id}', [
    'as' => 'profile', 'uses' => 'Profile@delete'
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

$router->get(
    '/user',
    [
        'as' => 'user',
        'uses' => 'User@index'
    ]
);

$router->post('/user', [
    'middleware' => 'auth',
    'as' => 'user', 'uses' => 'User@post'
]);


$router->put('/user', [
    'as' => 'user',
    'uses' => 'User@put'
]);

$router->delete('/user/{id}', [
    'as' => 'user',
    'uses' => 'User@del'
]);

$router->put('/user/active', [
    'as' => 'user', 'uses' => 'User@active'
]);
