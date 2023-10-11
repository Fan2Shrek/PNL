<?php

namespace Pnl\Console;

use Pnl\App\CommandInterface;
use Pnl\Console\Input\InputInterface;

class InputResolver implements InputResolverInterface
{
    public function resolve(CommandInterface $command, InputInterface $arguments): bool
    {
        die('resolve');
        return TRUE;
    }
}
