<?php

namespace Tests\Unit\Container\Examples;

class OneArrayArgument
{
    /**
     * @var array
     */
    private $array;

    public function __construct(array $array)
    {
        $this->array = $array;
    }
}