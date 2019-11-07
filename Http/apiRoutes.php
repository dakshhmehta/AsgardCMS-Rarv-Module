<?php
Route::post('login', [
    'as'   => 'api.rarv.user.login',
    'uses' => 'AuthController@postLogin',
]);

$router->group(
    ['prefix' => '/rarv', 'middleware' => ['api.token']],
    function ($router) {

        $router->post('events/trigger/{action}/{id}', 'EventsController@trigger');
    }
);
