<?php

use App\Controllers\AppController;
use App\Controllers\LatestTweetController;

$router->get('/', AppController::class, 'show');
$router->get('/tweets', LatestTweetController::class, 'index');