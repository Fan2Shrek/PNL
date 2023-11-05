<?php

namespace Pnl\Service\Interfaces;

interface ClassAdapterInterface
{
    public function adapt(string $namespace): bool;

    /**
     * @param string[] $namespaces
    */
    public function adaptAll(array $namespaces): bool;
}
