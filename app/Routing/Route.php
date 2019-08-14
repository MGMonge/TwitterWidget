<?php

namespace App\Routing;

class Route
{
    private $method;
    private $uri;
    private $controllerClass;
    private $controllerMethod;

    public function __construct($method, $uri, $controllerClass, $controllerMethod)
    {
        $this->method           = strtoupper($method);
        $this->uri              = trim($uri, '/');
        $this->controllerClass  = $controllerClass;
        $this->controllerMethod = $controllerMethod;
    }

    public function matches($method, $uri)
    {
        return $this->method === $method and $this->uri === $uri;
    }

    public function method()
    {
        return $this->method;
    }

    public function uri()
    {
        return $this->uri;
    }

    public function controllerMethod()
    {
        return $this->controllerMethod;
    }

    public function controllerClass()
    {
        return $this->controllerClass;
    }
}