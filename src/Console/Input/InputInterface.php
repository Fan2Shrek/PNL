<?php

namespace Pnl\Console\Input;

interface InputInterface
{
    public function __get(string $name): mixed;

    /** @return array<string, mixed> */
    public function getAllArguments(): array;
}
