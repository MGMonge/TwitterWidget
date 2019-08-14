<?php

namespace Tests\Unit\Container\Examples;

class OneRecursiveArgument
{
    /**
     * @var OneClassArgument
     */
    private $class;

    public function __construct(OneClassArgument $class)
    {
        $this->class = $class;
    }
}