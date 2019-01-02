<?php

$router->group(['prefix' => '/rarv', 'middleware' => ['api.token']],
    function ($router) {
        $router->post('events/trigger/{action}/{id}', 'EventsController@trigger');
    });
