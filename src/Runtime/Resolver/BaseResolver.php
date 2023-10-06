<?php

namespace Pnl\Runtime\Resolver;

class BaseResolver implements ResolverInterface
{
    public function resolve(mixed $className): object
    {
        return new $className();
    }
}
