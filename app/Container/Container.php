<?php

namespace App\Container;

use Exception;
use ReflectionClass;

class Container
{
    public function resolve($class)
    {
        return new $class(...$this->dependencies($class));
    }

    private function dependencies($class)
    {
        $dependencies = [];

        $reflectionClass = new ReflectionClass($class);

        $constructor = $reflectionClass->getConstructor();

        if ($constructor === null) {
            return [];
        }

        foreach ($constructor->getParameters() as $parameter) {
            // At the moment I handle only what I need for this job test
            // TODO: Handle all type of parameters (?)
            if ($parameter->isArray()) {
                $dependencies[] = [];
            } else {
                $dependencyClass = $parameter->getClass()->getName();

                if ( ! class_exists($dependencyClass)) {
                    throw new Exception(sprintf('Class [%s] not found', $dependencyClass));
                }

                $dependencies[] = $this->resolve($dependencyClass);
            }
        }

        return $dependencies;
    }
}