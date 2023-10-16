<?php

namespace Pnl\Console;

use Pnl\App\CommandInterface;
use Pnl\Console\Input\ArgumentBag;
use Pnl\Console\Input\ArgumentType;
use Pnl\Console\Input\InputInterface;
use Pnl\Console\Input\ArgumentDefinition;

class InputResolver implements InputResolverInterface
{
    public function resolve(CommandInterface $command, InputInterface $arguments): InputInterface
    {
        foreach ($arguments->getAllArguments() as $name => $value) {
            if (!$this->validateArgument($name, $value, $command::getArguments())) {
                throw new \LogicException(sprintf('Could not resolve %s argument', $name));
            }
        }

        return $arguments;
    }

    private function validateArgument(string $name, mixed $value, ArgumentBag $bag): TRUE
    {
        if (!$bag->has($name)) {
            $commands = array_map(fn ($arg) => $arg->getName(), $bag->getAll());

            throw new \InvalidArgumentException(sprintf('The %s option does not exist available option are : %s', $name, join(' ', $commands)));
        }

        if (!$this->validateType($value, $bag->get($name))) {
            $type = $bag->get($name)->getType();

            throw new \InvalidArgumentException(sprintf('The %s option only supports %s type', $name, $type->value));
        }

        return TRUE;
    }

    private function validateType(mixed $value, ArgumentDefinition $definition): bool
    {
        if (null == $definition->getType()) {
            return TRUE;
        }

        switch ($definition->getType()) {
            case ArgumentType::INT:
                return is_numeric($value);
            case ArgumentType::FLOAT:
                return is_float($value);
            case ArgumentType::STRING:
                return is_string($value);
            case ArgumentType::BOOLEAN:
                return is_bool($value);
            default:
                return FALSE;
        }
    }
}
