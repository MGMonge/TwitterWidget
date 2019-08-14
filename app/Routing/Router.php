<?php

namespace App\Routing;

use App\Container\Container;

class Router
{
    /** @var Container */
    private $container;

    public function __construct(Container $application)
    {
        $this->container = $application;
    }

    /** @var Route[] */
    private $routes = [];

    public function get($uri, $controllerClass, $controllerMethod)
    {
        $route = new Route('GET', $uri, $controllerClass, $controllerMethod);

        $this->routes[] = $route;

        return $route;
    }

    public function direct($method, $uri)
    {
        $route = $this->findRoute($method, $uri);

        $controller = $this->container->resolve($route->controllerClass());

        return $controller->{$route->controllerMethod()}();
    }

    public function findRoute($method, $uri)
    {
        foreach ($this->routes as $route) {
            if ($route->matches($method, $uri)) {
                return $route;
            }
        }

        throw new RouteNotFound(sprintf('Route [%s] not found', $uri));
    }

    public function routes()
    {
        return $this->routes;
    }
}