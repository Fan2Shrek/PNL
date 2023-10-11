<?php

namespace Pnl\Console\Input;

interface InputInterface
{
    public function getArgument(string $name): mixed;

    /** @return array<string mixed> */
    public function getAllArguments(): array;
}
