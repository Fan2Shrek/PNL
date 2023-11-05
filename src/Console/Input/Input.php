<?php

namespace Pnl\Console\Input;

class Input implements InputInterface
{
    /** @var array<string, mixed>> */
    private array $argumentsList = [];

    /**
     * @param array<string, mixed> $args
    */
    public function __construct(array $args = [])
    {
        if (empty($args)) {
            $args = $_SERVER['argv'];
        }

        $this->argumentsList = $this->parseArguments($args);
    }

    public function __get(string $name): mixed
    {
        if ($this->hasArgument($name)) {
            return $this->argumentsList[$name];
        }

        return null;
    }

    public function getAllArguments(): array
    {
        return $this->argumentsList;
    }

    public function hasArgument(string $name): bool
    {
        return isset($this->argumentsList[$name]);
    }

    /**
     * @param array<string> $args
     *
     * @return array<string, mixed>
    */
    private function parseArguments(array $args): array
    {
        $arguments = [];

        foreach ($args as $value) {
            if (str_starts_with($value, '--') && str_contains($value, '=')) {
                preg_match('/--(.*)=(.*)/', $value, $matches);

                $arguments[$matches[1]] = $matches[2];

                continue;
            } elseif (str_starts_with($value, '--')) {
                preg_match('/--(.*)/', $value, $matches);

                $arguments[$matches[1]] = true;
            }
        }

        return $arguments;
    }
}
