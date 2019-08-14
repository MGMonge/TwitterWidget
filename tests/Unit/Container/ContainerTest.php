<?php

namespace Tests\Unit\Container;

use App\Container\Container;
use Exception;
use Tests\TestCase;
use Tests\Unit\Container\Examples\EmptyClass;
use Tests\Unit\Container\Examples\MultipleArguments;
use Tests\Unit\Container\Examples\OneArrayArgument;
use Tests\Unit\Container\Examples\OneClassArgument;
use Tests\Unit\Container\Examples\OneNonExistingClass;
use Tests\Unit\Container\Examples\OneRecursiveArgument;

class ContainerTest extends TestCase
{
    /**
     * @var Container
     */
    protected $SUT;

    function _before()
    {
        $this->SUT = new Container;
    }

    /** @test */
    function it_resolves_a_class_without_arguments()
    {
        $expected = new EmptyClass;

        $actual = $this->SUT->resolve(EmptyClass::class);

        $this->assertEquals($expected, $actual);
    }

    /** @test */
    function it_resolves_a_class_with_single_class_argument()
    {
        $expected = new OneClassArgument(new EmptyClass);

        $actual = $this->SUT->resolve(OneClassArgument::class);

        $this->assertEquals($expected, $actual);
    }

    /** @test */
    function it_resolves_a_class_with_single_array_argument()
    {
        $expected = new OneArrayArgument([]);

        $actual = $this->SUT->resolve(OneArrayArgument::class);

        $this->assertEquals($expected, $actual);
    }

    /** @test */
    function it_resolves_a_class_with_multiple_arguments()
    {
        $expected = new MultipleArguments(new EmptyClass, []);

        $actual = $this->SUT->resolve(MultipleArguments::class);

        $this->assertEquals($expected, $actual);
    }

    /** @test */
    function it_resolves_a_class_with_single_recursive_argument()
    {
        $expected = new OneRecursiveArgument(new OneClassArgument(new EmptyClass), []);

        $actual = $this->SUT->resolve(OneRecursiveArgument::class);

        $this->assertEquals($expected, $actual);
    }

    /** @test */
    function it_throws_an_exception_when_class_is_not_found()
    {
        $this->expectException(Exception::class);

        $this->SUT->resolve(OneNonExistingClass::class);
    }
}