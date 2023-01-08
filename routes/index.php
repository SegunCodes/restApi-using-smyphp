<?php

require dirname(__DIR__).'/config/app.php';
use App\Http\Controllers\AppController;
use App\Http\Controllers\User\UserController;


/*
|--------------------------------------------------------------------------
| Routes
|--------------------------------------------------------------------------
|
| Here is where you can register routes for your application. 
|
*/

$app->router->get('/', function(){
    return "Hello world";
});
$app->router->get('/home', [AppController::class, 'home']);
$app->router->get('/login', [UserController::class, 'login']);
$app->router->post('/login', [UserController::class, 'login']);
$app->router->post('/register', [UserController::class, 'register']);
$app->router->get('/logout', [UserController::class, 'logout']);

$app->run();