<?php

namespace Tests\Unit\Routing;

use App\Routing\Route;
use Tests\TestCase;

class RouteTest extends TestCase
{
    /** @test */
    function it_can_be_constructed()
    {
        $route = new Route('post', '/comments', 'CommentController', 'store');

        $this->assertEquals('POST', $route->method());
        $this->assertEquals('comments', $route->uri());
        $this->assertEquals('CommentController', $route->controllerClass());
        $this->assertEquals('store', $route->controllerMethod());
    }

    /** @test */
    function it_matches_with_method_and_uri()
    {
        $route = new Route('post', '/comments', 'CommentController', 'store');

        $this->assertFalse($route->matches('GET', 'comments'));
        $this->assertFalse($route->matches('POST', 'foobar'));
        $this->assertTrue($route->matches('POST', 'comments'));
    }
}