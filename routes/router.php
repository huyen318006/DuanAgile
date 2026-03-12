<?php

use App\Controllers\HomeController;
use App\Controllers\MenuController;
use Bramus\Router\Router;

$router = new Router;

$router->get('/', HomeController::class . '@index');

$router->get('home', HomeController::class . '@index');

$router->get('menu', MenuController::class . '@index');

$router->run();
