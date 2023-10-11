<?php

namespace Pnl\Console\Input;

use Traversable;

class ArgumentBag
{
    private array $arguments = [];

    public function addArgument(ArgumentDefinition $arg): static
    {
        $this->arguments[$arg->getName()] = $arg;

        return $this;
    }

    public function add(string $name, bool $required = false, ?string $description = null, ?ArgumentType $type = null, mixed $default = null): static
    {
        $this->addArgument(new ArgumentDefinition($name, $required, $description, $type, $default));

        return $this;
    }

    public function get(string $name): ArgumentDefinition
    {
        if (!$this->has($name)) {
            throw new \InvalidArgumentException(sprintf('Argument %s does not exist', $name));
        }

        return $this->arguments[$name];
    }

    public function has(string $name): bool
    {
        return array_key_exists($name, $this->arguments);
    }

    public function getAll(): array
    {
        return $this->arguments;
    }

    public function getIterator(): Traversable
    {
        return new \ArrayIterator($this->arguments);
    }
}
