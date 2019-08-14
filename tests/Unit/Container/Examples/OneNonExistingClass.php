<?php

namespace Tests\Unit\Container\Examples;

class OneNonExistingClass
{
    /**
     * @var NonExistingClass
     */
    private $class;

    public function __construct(NonExistingClass $class)
    {
        $this->class = $class;
    }
}