<?php

namespace Tests\Unit\Container\Examples;

class OneClassArgument
{
    /**
     * @var EmptyClass
     */
    private $foo;

    public function __construct(EmptyClass $foo)
    {
        $this->foo = $foo;
    }
}