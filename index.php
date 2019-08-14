<?php

use App\Container\Container;
use App\Routing\Router;
use Dotenv\Dotenv;

require __DIR__ . '/vendor/autoload.php';

session_start();

$container = new Container;
$router    = new Router($container);

$env = Dotenv::create(__DIR__);
$env->load();

require 'routes.php';

$method = $_SERVER['REQUEST_METHOD'];
$uri    = trim($_SERVER['REQUEST_URI'], '/');

echo $router->direct($method, $uri);

