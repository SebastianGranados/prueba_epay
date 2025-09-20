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

$router->group(['prefix' => 'api'], function () use ($router) {
  // Ruta de cliente
  $router->post('customer/create',  ['uses' => 'CustomerController@register']);
  
  // Rutas de billetera
  $router->post('wallet/recharge', ['uses' => 'WalletController@recharge']); // Recargar de billetera
  $router->get('wallet/balance', ['uses' => 'WalletController@balance']);
});