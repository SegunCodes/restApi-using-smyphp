<?php

require dirname(__DIR__).'/config/app.php';
use App\Http\Controllers\AppController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\PostController;


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
$app->router->post('/login', [UserController::class, 'login']);
$app->router->post('/register', [UserController::class, 'register']);
$app->router->post('/create', [PostController::class, 'create']);
$app->router->get('/view-all', [PostController::class, 'viewAll']);
$app->router->get('/view/{id}', [PostController::class, 'viewOne']);

$app->run();