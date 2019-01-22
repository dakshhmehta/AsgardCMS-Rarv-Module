<?php

use Illuminate\Routing\Router;
use Modules\Rarv\Entities\User;
use Modules\Rarv\Notifications\SendSMS;

/** @var Router $router */

$router->group(['prefix' => '/rarv'], function (Router $router) {
    $router->get('test-sms', function () {
        $user = User::first();

        $user->notify(new SendSMS('Chibhd, ##first_name##'));
    });
});
