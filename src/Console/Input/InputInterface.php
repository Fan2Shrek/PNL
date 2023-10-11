<?php

namespace Pnl\Console\Input;

interface InputInterface
{
    public function getArgument(string $name): mixed;

    public function getAllArguments(): array;
}
