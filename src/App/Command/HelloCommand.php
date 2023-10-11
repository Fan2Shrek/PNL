<?php

namespace Pnl\App\Command;

use Pnl\App\AbstractCommand;

class HelloCommand extends AbstractCommand
{
    protected const NAME = 'hello';

    public function getDescription(): string
    {
        return 'Test command';
    }

    public function __invoke(): void
    {
        echo 'Hello, world!', PHP_EOL;
    }
}