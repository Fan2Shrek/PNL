<?php

namespace Pnl\Service;

use Pnl\Service\Exception\FailLoadClass;
use Pnl\Service\Interfaces\ClassAdapterInterface;

class ClassAdapter implements ClassAdapterInterface
{
    /** @var string[] */
    private array $adaptedNamespaces = [];

    /** @var \ReflectionClass[] */
    private array $reflectionList = [];

    public function adapt(string $namespace): bool
    {
        if ($this->isAdapted($namespace)) {
            return true;
        }

        if (!class_exists($namespace)) {
            throw new \LogicException('Class should exist');
        }

        $this->doReflect($namespace);
        $this->adaptedNamespaces[] = $namespace;

        return true;
    }

    public function adaptAll(array $namespaces): bool
    {
        foreach ($namespaces as $namespace) {
            $this->adapt($namespace);
        }

        return true;
    }

    private function isAdapted(string $namespace): bool
    {
        return in_array($namespace, $this->adaptedNamespaces);
    }

    private function doReflect(string $namespace): void
    {
        try {
            $this->reflectionList[$namespace] = new \ReflectionClass($namespace);
        } catch (\ReflectionException $e) {
            throw new FailLoadClass($e->getMessage());
        }
    }

    public function getReflections(): array
    {
        return $this->reflectionList;
    }
}
