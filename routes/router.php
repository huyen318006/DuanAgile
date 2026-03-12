<?php
use App\Controllers\HomeController;
use App\Models\Users;
use Bramus\Router\Router;
use App\Controllers\UserController;
use App\Controllers\FoodController;

$router = new Router;

$router->get('/', FoodController::class . '@index');
$router->get('/foods', FoodController::class . '@index');
// Đăng nhập
$router->get('login',UserController::class.'@login');
$router->post('checklogin',UserController::class.'@checklogin');
 // Đăng xuất
 $router->get('logout', UserController::class.'@logout');
 //đăng kí tài khoản
 $router->get('register',UserController::class.'@register');
 $router->post('addregister',UserController::class.'@addregister');
 //quên mật khẩu
 $router->get('forgotpassword',UserController::class.'@forgotpassword');
 $router->post('sendforgotpassword',UserController::class.'@sendforgotpassword');
 $router->post('updatepassword',UserController::class. '@updatepassword');
$router->run();
