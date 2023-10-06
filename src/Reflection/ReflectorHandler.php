<?php

namespace Pnl\Reflection;

use ReflectionClass;

class ReflectorHandler implements ReflectorInterface
{
    public function reflect(string $namespace): ReflectionClass
    {
        return new ReflectionClass($namespace);
    }
}
