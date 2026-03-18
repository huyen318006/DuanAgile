<?php

use App\Controllers\HomeController;
use App\Controllers\MenuController;
use App\Models\Users;
use Bramus\Router\Router;
use App\Controllers\UserController;
use App\Controllers\FoodController;
use App\Controllers\RestaurantController;
use App\Controllers\OrderController;

$router = new Router;

$router->get('/', FoodController::class . '@index');
$router->get('/foods', FoodController::class . '@index');

$router->get('menu', MenuController::class . '@index');

// Đăng nhập
$router->get('login', UserController::class . '@login');
$router->post('checklogin', UserController::class . '@checklogin');
// Đăng xuất
$router->get('logout', UserController::class . '@logout');
//đăng kí tài khoản
$router->get('register', UserController::class . '@register');
$router->post('addregister', UserController::class . '@addregister');
//quên mật khẩu
$router->get('forgotpassword', UserController::class . '@forgotpassword');
$router->post('sendforgotpassword', UserController::class . '@sendforgotpassword');
$router->post('updatepassword', UserController::class . '@updatepassword');
//hồ sơ cá nhân
$router->get('profile', UserController::class . '@profile');
$router->get('orderforme', UserController::class . '@orderforme');
//sửa hồ sơ cá nhân
$router->get('editprofile', UserController::class . '@editprofile');
$router->post('updateprofile', UserController::class . '@updateprofile');

//nhà hàng nổi bật
$router->get('restaurant/(\d+)', RestaurantController::class.'@show');

//order
$router->get('foods/{id}/order', OrderController::class.'@order');
// add order
$router->post('order/add',OrderController::class.'@orderadd');

$router->run();
