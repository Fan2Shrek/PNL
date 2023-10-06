<?php

namespace Pnl\Service\Interfaces;

interface ClassAdapterInterface
{
    public function adapt(string $namespace): bool;

    public function adaptAll(array $namespaces): bool;
}
