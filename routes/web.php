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
$router->post('/user/reg','User\UserController@reg');
$router->post('/user/login','User\UserController@login');
$router->post('/user/weather','User\UserController@weather');
$router->post('/user/update','User\UserController@update');

$router->post('/text/decrypt1','Text\TextController@decrypt1');
$router->post('/text/decrypt2','Text\TextController@decrypt2');
$router->post('/text/decrypt3','Text\TextController@decrypt3');
$router->post('/text/sign','Text\TextController@sign');

$router->post('/text/o1','Text\TextController@o1');

$router->post('/text/reg','Text\UserController@reg');
$router->post('/text/login','Text\UserController@login');