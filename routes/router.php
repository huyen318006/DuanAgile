<?php
use App\Controllers\HomeController;
use Bramus\Router\Router;

$router = new Router;

$router->get('/', HomeController::class . '@index');

$router->get('home', HomeController::class . '@index');

$router->run();
