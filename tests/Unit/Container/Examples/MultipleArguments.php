<?php

namespace Tests\Unit\Container\Examples;

class MultipleArguments
{
    /**
     * @var EmptyClass
     */
    private $class;
    /**
     * @var array
     */
    private $array;

    public function __construct(EmptyClass $class, array $array)
    {
        $this->class = $class;
        $this->array = $array;
    }
}