<?php

namespace Pnl\App\Command;

use Pnl\App\AbstractCommand;
use Pnl\Console\Input\ArgumentBag;
use Pnl\Console\Input\ArgumentType;

class TestCommand extends AbstractCommand
{
    protected const NAME = 'test';

    public static function getArguments(): ArgumentBag
    {
        return (new ArgumentBag())
            ->add('test', TRUE, 'Test argument', ArgumentType::STRING)
            ->add('joe', FALSE, 'Test argument 2', ArgumentType::BOOLEAN, TRUE);
    }

    public function getDescription(): string
    {
        return 'Test command';
    }

    public function __invoke(): void
    {
        dd(\func_get_args());
        echo 'Test', PHP_EOL;
    }
}
