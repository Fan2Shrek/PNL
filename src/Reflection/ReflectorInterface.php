<?php

namespace Pnl\Reflection;

interface ReflectorInterface
{
    public function reflect(string $namespace): \ReflectionClass;
}
