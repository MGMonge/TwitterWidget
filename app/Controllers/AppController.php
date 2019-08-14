<?php

namespace App\Controllers;

class AppController
{
    public function show()
    {
        require_once __DIR__ . '/../../resources/views/app.php';
    }
}