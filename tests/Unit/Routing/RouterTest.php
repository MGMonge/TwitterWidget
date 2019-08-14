<?php

namespace Tests\Unit\Routing;

use App\Container\Container;
use App\Routing\Route;
use App\Routing\RouteNotFound;
use App\Routing\Router;
use Tests\TestCase;

class RouterTest extends TestCase
{
    /**
     * @var Router
     */
    protected $SUT;

    function _before()
    {
        $this->SUT = new Router(new Container);
    }

    /** @test */
    function adding_single_route()
    {
        $expected = new Route('GET', 'foo', 'FooController', 'show');

        $actual = $this->SUT->get('/foo', 'FooController', 'show');

        $this->assertEquals($expected, $actual);
    }

    /** @test */
    function adding_multiple_routes()
    {
        $routes = [
            $this->SUT->get('/foo', 'FooController', 'show'),
            $this->SUT->get('/bar', 'BarController', 'show'),
            $this->SUT->get('/baz', 'BazController', 'show'),
        ];

        $this->assertEquals($routes, $this->SUT->routes());
    }

    /** @test */
    function it_finds_a_route()
    {
        $routes = [
            $this->SUT->get('/foo', 'FooController', 'show'),
            $this->SUT->get('/bar', 'BarController', 'show'),
            $this->SUT->get('/baz', 'BazController', 'show'),
        ];

        $actual = $this->SUT->findRoute('GET', 'bar');

        $this->assertEquals($routes[1], $actual);
    }

    /** @test */
    function it_throws_an_exception_when_route_is_not_found()
    {
        $this->expectException(RouteNotFound::class);

        $this->SUT->findRoute('GET', 'foo');
    }

    /** @test */
    function it_directs_to_the_route_controller_method()
    {
        $this->SUT->get('/test', FakeController::class, 'foobar');

        $actual = $this->SUT->direct('GET', 'test');

        $this->assertEquals('This is fake content', $actual);
    }
}