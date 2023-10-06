<?php

namespace Pnl\Runtime\Resolver;

interface ResolverInterface
{
    public function resolve(mixed $className): object;
}
