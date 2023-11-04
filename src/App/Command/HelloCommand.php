<?php

namespace Pnl\App\Command;

use Pnl\App\AbstractCommand;
use Pnl\Console\Input\ArgumentBag;
use Pnl\Console\Input\InputInterface;

class HelloCommand extends AbstractCommand
{
    protected const NAME = 'hello';

    public function getDescription(): string
    {
        return 'Test command';
    }

    public function __invoke(InputInterface $input): void
    {
        echo 'Hello, world!', PHP_EOL;
    }
}
